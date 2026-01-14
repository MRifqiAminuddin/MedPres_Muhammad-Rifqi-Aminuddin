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

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                Encounter::select('id', 'doctor_id', 'patient_id', 'encounter_date', 'status', 'identity')
                    ->whereDate('encounter_date', Carbon::today()->format('Y-m-d'))
                    ->where('status', 'Periksa')
                    ->where('doctor_id', Auth::user()->doctor->id)
                    ->orderBy('encounter_date', 'asc')
            )
                ->addColumn('patient_name', fn(Encounter $e) => $e->patient->name)
                ->addColumn('patient_gender', fn(Encounter $e) => $e->patient->gender)
                ->addColumn('action', function (Encounter $encounter) {
                    return view('layout.components.action', [
                        'name'     => $encounter->patient->name,
                        'identity' => $encounter->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('consultation.index');
    }
}
