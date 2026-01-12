<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                Patient::select('id', 'name', 'birth_date', 'gender', 'identity')->orderBy('id')
            )
                ->addColumn('action', function (Patient $patient) {
                    return view('layout.components.action', [
                        'name' => $patient->name,
                        'identity' => $patient->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('management.patient');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => ['required', Rule::in(['Laki', 'Perempuan'])],
        ]);

        Patient::create([
            ...$validated,
            'identity' => Str::random(10),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambah data',
        ]);
    }


    public function show(Request $request, string $identity)
    {
        if ($request->ajax()) {
            $patient = Patient::select('id', 'name', 'birth_date', 'gender', 'identity')->where('identity', $identity)->first();
            if ($patient) {
                $data = [
                    'status' => 'success',
                    'message' => 'Data berhasil ditemukan',
                    'data' => [
                        'name' => $patient->name,
                        'birth_date' => $patient->birth_date,
                        'gender' => $patient->gender,
                        'identity' => $patient->identity
                    ]
                ];
                return response()->json($data);
            }
        }
    }

    public function update(Request $request, string $identity)
    {
        abort_if(!$request->ajax(), 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => ['required', Rule::in(['Laki', 'Perempuan'])],
        ]);

        $patient = Patient::where('identity', $identity)->firstOrFail();
        $patient->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil memperbarui data',
        ]);
    }


    public function delete(Request $request, string $identity)
    {
        if ($request->ajax()) {
            $patient = Patient::where('identity', $identity)->first();
            $patientDelete = $patient->delete();
            if ($patientDelete) {
                $data = [
                    'status' => 'success',
                    'message' => 'Berhasil hapus data'
                ];
                return response()->json($data);
            }
        }
    }
}
