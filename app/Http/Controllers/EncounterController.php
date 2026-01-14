<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Events\EncounterUpdated;

use App\Models\Encounter;
use App\Models\Patient;
use App\Models\Doctor;

use function Symfony\Component\Clock\now;

class EncounterController extends Controller
{
    public function index(Request $request)
    {
        $station = Auth::user()->admin->station;
        $doctors = Doctor::select('id', 'user_id', 'station')->where('station', $station)->get();
        $doctorIds = $doctors->pluck('id')->toArray();

        if ($request->ajax()) {
            return DataTables::of(
                Encounter::select('id', 'doctor_id', 'patient_id', 'encounter_date', 'status', 'identity')
                    ->whereDate('encounter_date', Carbon::today()->format('Y-m-d'))
                    ->where('status', 'Belum Selesai')
                    ->whereIn('doctor_id', $doctorIds)
                    ->orderBy('encounter_date', 'asc')
            )
                ->addColumn('doctor_name', fn(Encounter $e) => $e->doctor->user->name)
                ->addColumn('patient_name', fn(Encounter $e) => $e->patient->name)
                ->addColumn('patient_gender', fn(Encounter $e) => $e->patient->gender)
                ->addColumn('time', fn(Encounter $e) => $e->encounter_date->format('H:i:s'))
                ->addColumn('action', function (Encounter $encounter) {
                    return view('layout.components.action', [
                        'name'     => $encounter->patient->name,
                        'identity' => $encounter->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('encounter.index', compact(['doctors']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patientIdentity' => ['required', 'string', 'max:50'],
            'patientName'     => ['required', 'string', 'max:255'],
            'doctorIdentity'  => ['required', 'string', 'max:50'],
            'doctorName'      => ['required', 'string', 'max:255'],
            'systole'         => ['required', 'numeric', 'min:0'],
            'diastole'        => ['required', 'numeric', 'min:0'],
            'bodyHeight'      => ['required', 'numeric', 'min:0'],
            'bodyWeight'      => ['required', 'numeric', 'min:0'],
            'heartRate'       => ['required', 'numeric', 'min:0'],
            'respirationRate' => ['required', 'numeric', 'min:0'],
            'bodyTemperature' => ['required', 'numeric', 'between:30,45'],
            'anamnesis'       => ['required', 'string'],
            'captured_image'  => ['nullable', 'string'],
            'fileNameDocument' => ['nullable', 'string'],
        ], [
            'bodyTemperature.between' => 'Suhu tubuh harus berada di antara 30°C - 45°C.',
            'numeric' => ':attribute harus berupa angka.',
        ]);

        $identity = Str::upper(Str::random(10));
        $imageData = $request['captured_image'];
        $fileName = null;

        if ($imageData) {
            $folderPath = public_path('assets/upload/other-documents');

            $imageParts = explode(";base64,", $imageData);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);

            $fileName = $identity . '_' . time() . '_' . $request['patientIdentity'] . '.' . $imageType;
            $fileFullPath = $folderPath . '/' . $fileName;
            file_put_contents($fileFullPath, $imageBase64);
        }

        $patient = Patient::select('id', 'identity')->where('identity', $request['patientIdentity'])->first();
        $doctor = Doctor::select('id', 'identity')->where('identity', $request['doctorIdentity'])->first();

        Encounter::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'body_height' => $request['bodyHeight'],
            'body_weight' => $request['bodyWeight'],
            'systole' => $request['systole'],
            'diastole' => $request['diastole'],
            'heart_rate' => $request['heartRate'],
            'respiration_rate' => $request['respirationRate'],
            'body_temperature' => $request['bodyTemperature'],
            'anamnesis' => $request['anamnesis'],
            'other_document' => $fileName,
            'encounter_date' => now(),
            'identity' => $identity,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil ditambahkan',
        ]);
    }

    public function show(Request $request, string $identity)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $encounter = Encounter::where('identity', $identity)->firstOrFail();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data apoteker berhasil diperbarui',
            'data'    => $encounter,
            'added'   => [
                'doctor_identity' => $encounter->doctor->identity,
                'doctor_name' => $encounter->doctor->user->name,
                'patient_identity' => $encounter->patient->identity,
                'patient_name' => $encounter->patient->name,
            ]
        ]);
    }

    public function update(Request $request, string $identity)
    {

        if (!$request->ajax()) {
            abort(404);
        }

        $validated = $request->validate([
            'patientIdentity' => ['required', 'string', 'max:50'],
            'doctorIdentity'  => ['required', 'string', 'max:50'],
            'systole'         => ['required', 'numeric', 'min:0'],
            'diastole'        => ['required', 'numeric', 'min:0'],
            'bodyHeight'      => ['required', 'numeric', 'min:0'],
            'bodyWeight'      => ['required', 'numeric', 'min:0'],
            'heartRate'       => ['required', 'numeric', 'min:0'],
            'respirationRate' => ['required', 'numeric', 'min:0'],
            'bodyTemperature' => ['required', 'numeric', 'between:30,45'],
            'anamnesis'       => ['required', 'string'],
            'captured_image'  => ['nullable', 'string'],
            'fileNameDocument' => ['nullable', 'string'],
        ], [
            'bodyTemperature.between' => 'Suhu tubuh harus di antara 30°C - 45°C.',
            'numeric' => ':attribute harus berupa angka.',
        ]);

        $encounter = Encounter::where('identity', $identity)->firstOrFail();
        $fileName = $encounter->other_document;
        $imageData = $request->captured_image;

        if (!empty($imageData) && str_contains($imageData, ';base64,')) {
            $folderPath = public_path('assets/upload/other-documents');

            if ($encounter->other_document == $request['fileNameDocument']) {
                File::delete($folderPath . '/' . $encounter->other_document);
            }

            $imageParts = explode(";base64,", $imageData);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1] ?? 'jpg';
            $imageBase64 = base64_decode($imageParts[1]);

            $fileName = Str::upper(Str::random(10)) . '_' . time() . '_' . $request->patientIdentity . '.' . $imageType;

            file_put_contents($folderPath . '/' . $fileName, $imageBase64);
        }

        $patient = Patient::where('identity', $request->patientIdentity)->firstOrFail();
        $doctor = Doctor::where('identity', $request->doctorIdentity)->firstOrFail();

        $encounter->update([
            'doctor_id'        => $doctor->id,
            'patient_id'       => $patient->id,
            'body_height'      => $request->bodyHeight,
            'body_weight'      => $request->bodyWeight,
            'systole'          => $request->systole,
            'diastole'         => $request->diastole,
            'heart_rate'       => $request->heartRate,
            'respiration_rate' => $request->respirationRate,
            'body_temperature' => $request->bodyTemperature,
            'anamnesis'        => $request->anamnesis,
            'other_document'   => $fileName,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui',
            'data'    => $encounter
        ]);
    }


    public function searchPatient(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                Patient::select('id', 'name', 'birth_date', 'gender', 'medical_record_number', 'identity')->orderBy('id')
            )
                ->addColumn('action', function (Patient $patient) {
                    return view('layout.components.action', [
                        'mode' => 'patient',
                        'name' => $patient->name,
                        'identity' => $patient->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function searchDoctor(Request $request)
    {
        $station = Auth::user()->admin->station;
        if ($request->ajax()) {
            return DataTables::of(
                Doctor::select('id', 'user_id', 'str_number', 'sip_number', 'station', 'identity')->where('station', $station)->orderBy('id')
            )
                ->addColumn('name', function (Doctor $doctor) {
                    return $doctor->user->name;
                })
                ->addColumn('gender', function (Doctor $doctor) {
                    return $doctor->user->gender;
                })
                ->addColumn('action', function (Doctor $doctor) {
                    return view('layout.components.action', [
                        'mode' => 'doctor',
                        'name' => $doctor->user->name,
                        'identity' => $doctor->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function call(Request $request, string $identity)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $encounter = Encounter::where('identity', $identity)->firstOrFail();
        $encounter->update([
            'status' => 'Periksa',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Aksi panggil pasien berhasil',
        ]);
    }
}
