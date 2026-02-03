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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\Encounter;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Prescription;
use App\Models\Variable;
use App\Models\PrescriptionMedicine;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                Encounter::select('id', 'doctor_id', 'patient_id', 'encounter_date', 'status', 'anamnesis', 'identity')
                    ->whereDate('encounter_date', Carbon::today()->format('Y-m-d'))
                    ->where('status', 'Periksa')
                    ->where('doctor_id', Auth::user()->doctor->id)
                    ->orderBy('encounter_date', 'asc')
            )
                ->addColumn('patient_name', fn(Encounter $e) => $e->patient->name)
                ->addColumn('patient_gender', fn(Encounter $e) => $e->patient->gender)
                ->addColumn('action', function (Encounter $encounter) {
                    return view('layout.components.action', [
                        'identity' => $encounter->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('consultation.index');
    }

    public function detail($identity)
    {
        $encounter = Encounter::where('identity', $identity)->firstOrFail();
        if (isset($encounter->prescription->prescriptionMedicines)) {
            $medicines = $encounter->prescription->prescriptionMedicines;
        } else {
            $medicines = null;
        }
        return view('consultation.detail', compact('encounter', 'medicines'));
    }

    public function medicineList(Request $request)
    {
        if ($request->ajax()) {
            $tokenRecord = Variable::where('name', 'Login')->first();
            $token = $tokenRecord ? $tokenRecord->content : '';
            $responseMedicineList = Http::withToken($token)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
            if ($responseMedicineList->unauthorized()) {
                $authResponse = Http::post('http://recruitment.rsdeltasurya.com/api/v1/auth', [
                    'email'    => 'mrifqi767@gmail.com',
                    'password' => '087754196023',
                ]);

                if ($authResponse->successful()) {
                    $authData = $authResponse->json();
                    $newToken = $authData['access_token'];

                    $tokenRecord->update([
                        'content' => $newToken
                    ]);

                    $responseMedicineList = Http::withToken($newToken)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
                } else {
                    Log::error('Auth API request failed', [
                        'status' => $authResponse->status(),
                        'body'   => $authResponse->body(),
                    ]);
                    return abort(500, 'Gagal login server.');
                }
            }

            $medicines = collect($responseMedicineList['medicines'])->map(fn($item) => (object) $item);
            // dd($medicines);

            return DataTables::of($medicines)
                ->addColumn('action', function ($medicine) {
                    return view('layout.components.action', [
                        'id' => $medicine->id,
                        'name' => $medicine->name,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function prescriptionCreate(Request $request)
    {
        $validated = $request->validate([
            'identity'         => 'required|string|exists:encounters,identity',
            'diagnosa'         => 'required|string',
        ]);

        $encounter = Encounter::where('identity', $validated['identity'])->firstOrFail();

        if (isset($encounter->prescription)) {
            $encounter->prescription->delete();
        }

        $encounter->update([
            'diagnosis' => $validated['diagnosa'],
            'status' => 'Sudah Selesai'
        ]);

        if (isset($validated['medicine_ids'])) {
            $prescription = Prescription::create([
                'encounter_id'       => $encounter->id,
                'prescription_date'  => now(),
                'identity'           => Str::upper(Str::random(10)),
            ]);

            foreach ($validated['medicine_ids'] as $index => $medicineId) {
                PrescriptionMedicine::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id'     => $medicineId,
                    'medicine_name'   => $validated['medicine_name'][$index],
                    'qty'             => $validated['qty'][$index],
                    'dosage'          => $validated['dosage'][$index],
                    'rule'            => $validated['rule'][$index],
                    'identity'        => Str::upper(Str::random(10)),
                ]);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Resep berhasil disimpan',
        ], 201);
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                Encounter::select('id', 'doctor_id', 'patient_id', 'encounter_date', 'status', 'anamnesis', 'identity')
                    ->whereDate('encounter_date', Carbon::today()->format('Y-m-d'))
                    ->where('status', 'Sudah Selesai')
                    ->where('doctor_id', Auth::user()->doctor->id)
                    ->orderBy('encounter_date', 'asc')
            )
                ->addColumn('patient_name', fn(Encounter $e) => $e->patient->name)
                ->addColumn('patient_gender', fn(Encounter $e) => $e->patient->gender)
                ->addColumn('action', function (Encounter $encounter) {
                    return view('layout.components.action', [
                        'identity' => $encounter->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
    }
}
