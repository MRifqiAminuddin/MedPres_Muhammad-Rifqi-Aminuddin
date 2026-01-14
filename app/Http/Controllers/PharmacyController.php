<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use Yajra\DataTables\Facades\DataTables;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Prescription::whereIn('status', ['Belum', 'Menunggu'])->orderBy('prescription_date', 'asc')->get())
                ->addColumn('patient_name', function (Prescription $prescription) {
                    return $prescription->encounter->patient->name;
                })
                ->addColumn('patient_birth_date', function (Prescription $prescription) {
                    return $prescription->encounter->patient->birth_date->format('d-m-Y');
                })
                ->addColumn('patient_age', function (Prescription $prescription) {
                    return round($prescription->encounter->patient->birth_date->diffInYears(now()));
                })
                ->addColumn('doctor_name', function (Prescription $prescription) {
                    return $prescription->encounter->doctor->name;
                })
                ->addColumn('station', function (Prescription $prescription) {
                    return $prescription->encounter->doctor->station;
                })
                ->addColumn('action', function (Prescription $prescription) {
                    return view('layout.components.action', [
                        'name' => $prescription->encounter->patient->name,
                        'identity' => $prescription->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('pharmacy.index');
    }
}
