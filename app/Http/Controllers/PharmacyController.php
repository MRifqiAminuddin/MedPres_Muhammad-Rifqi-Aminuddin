<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use App\Models\Variable;

use function Symfony\Component\Clock\now;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Prescription::whereIn('status', ['Belum', 'Menunggu'])->orderBy('prescription_date', 'asc')->get())
                ->addColumn('patient_name', function (Prescription $prescription) {
                    return $prescription->encounter->patient->name;
                })
                ->addColumn('prescription_date_formated', function (Prescription $prescription) {
                    return $prescription->prescription_date->format('d-m-Y');
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
                        'pharmacy_id' => $prescription->pharmacist_id,
                        'identity' => $prescription->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('pharmacy.index');
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Prescription::where('status', 'Sudah')->orderBy('prescription_date', 'asc')->get())
                ->addColumn('patient_name', function (Prescription $prescription) {
                    return $prescription->encounter->patient->name;
                })
                ->addColumn('prescription_date_formated', function (Prescription $prescription) {
                    return $prescription->prescription_date->format('d-m-Y');
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
                        'pharmacy_id' => $prescription->pharmacist_id,
                        'identity' => $prescription->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function show(Request $request, string $identity)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $mode = $request->input('mode');

        if ($mode == "pick" || $mode == "done") {
            $prescriptions = Prescription::where('identity', $identity)->get();
            if($prescriptions[0]->pharmacist_id != Auth::user()->pharmacist->id){
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Tugas sudah diambil apoteker lain',
                ], 400);
            }
        } elseif ($mode == "show") {
            $prescriptions = Prescription::where('pharmacist_id', Auth::user()->pharmacist->id)->get();
            if (!$prescriptions) {
                $prescriptions = [];
            }
        }

        $dataMedicines = [];
        $data = [];

        foreach ($prescriptions as $prescription) {
            if ($mode == "pick") {
                $prescription->update([
                    'pharmacist_id' => Auth::user()->pharmacist->id,
                    'status' => 'Menunggu'
                ]);
            }

            $medicines_lists = PrescriptionMedicine::where('prescription_id', $prescription->id)->get();

            $tokenRecord = Variable::where('name', 'Login')->first();
            $token = $tokenRecord ? $tokenRecord->content : '';

            // $response_medicines_list_api = Http::withToken($token)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
            // if ($response_medicines_list_api->unauthorized()) {
            //     $authResponse = Http::post('http://recruitment.rsdeltasurya.com/api/v1/auth', [
            //         'email'    => 'mrifqi767@gmail.com',
            //         'password' => '087754196023',
            //     ]);

            //     if ($authResponse->successful()) {
            //         $authData = $authResponse->json();
            //         $newToken = $authData['access_token'];

            //         $tokenRecord->update([
            //             'content' => $newToken
            //         ]);

            //         $response_medicines_list_api = Http::withToken($newToken)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
            //     } else {
            //         Log::error('Auth API request failed', [
            //             'status' => $authResponse->status(),
            //             'body'   => $authResponse->body(),
            //         ]);
            //         return abort(500, 'Gagal login server.');
            //     }
            // }
            // $allMedicines = collect($response_medicines_list_api['medicines'])->map(fn($item) => (object) $item);
            $prescription_date = $prescription->prescription_date->format("Y-m-d");

            foreach ($medicines_lists as $medicine_list) {
                $price = 0;
                $response_medicine_price_api = Http::withToken($token)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines/' . $medicine_list->medicine_id . '/prices');
                if ($response_medicine_price_api->unauthorized()) {
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

                        $response_medicine_price_api = Http::withToken($newToken)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
                    } else {
                        Log::error('Auth API request failed', [
                            'status' => $authResponse->status(),
                            'body'   => $authResponse->body(),
                        ]);
                        return abort(500, 'Gagal login server.');
                    }
                }

                // foreach ($allMedicines as $i => $allMedicine) {
                //     if ($allMedicine->id == $medicine_list->medicine_id) {
                //         $id = $allMedicine->id;
                //         $name = $allMedicine->name;
                //     }
                // }

                $id = $medicine_list->medicine_id;
                $name = $medicine_list->medicine_name;

                $allPrices = collect($response_medicine_price_api['prices'])->map(fn($item) => (object) $item);

                foreach ($allPrices as $allPrice) {
                    if ($allPrice->start_date["value"] <= $prescription_date && $allPrice->end_date["value"] >= $prescription_date) {
                        $price = $allPrice->unit_price;
                    }
                }

                $dataMedicines[] = [
                    'id' => $id,
                    'name' => $this->cleanMedicineName($name),
                    'qty' => $medicine_list->qty,
                    'price' => $price,
                    'dosage' => $medicine_list->dosage,
                    'rule' => $medicine_list->rule
                ];
            }

            $data[] = [
                'patient_name'  => $prescription->encounter->patient->name,
                'patient_age'   => round($prescription->encounter->patient->birth_date->diffInYears(now())),
                'medicines'      => $dataMedicines,
                'identity'      => $prescription->identity,
            ];
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data resep berhasil diambil',
            'data'    => $data,
        ]);
    }

    public function cancel($identity)
    {
        $prescription = Prescription::where('identity', $identity)->update([
            'pharmacist_id' => null,
            'status' => 'Belum'
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil membatalkan tugas'
        ]);
    }

    public function pay(Request $request, string $identity)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $totalPrice = 0;
        $selected_medicine_ids = $request->input('medicine_ids');

        $prescription = Prescription::where('identity', $identity)->firstOrFail();
        $dataMedicines = [];
        $data = [];

        $prescription->update([
            'status' => 'Sudah'
        ]);

        $medicines_lists = PrescriptionMedicine::where('prescription_id', $prescription->id)->get();

        $tokenRecord = Variable::where('name', 'Login')->first();
        $token = $tokenRecord ? $tokenRecord->content : '';

        $prescription_date = $prescription->prescription_date->format("Y-m-d");

        foreach ($medicines_lists as $medicine_list) {
            $price = 0;
            $response_medicine_price_api = Http::withToken($token)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines/' . $medicine_list->medicine_id . '/prices');
            if ($response_medicine_price_api->unauthorized()) {
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

                    $response_medicine_price_api = Http::withToken($newToken)->get('http://recruitment.rsdeltasurya.com/api/v1/medicines');
                } else {
                    Log::error('Auth API request failed', [
                        'status' => $authResponse->status(),
                        'body'   => $authResponse->body(),
                    ]);
                    return abort(500, 'Gagal login server.');
                }
            }

            $id = $medicine_list->medicine_id;
            $name = $medicine_list->medicine_name;

            $allPrices = collect($response_medicine_price_api['prices'])->map(fn($item) => (object) $item);

            foreach ($allPrices as $allPrice) {
                if ($allPrice->start_date["value"] <= $prescription_date->format("Y-m-d") && $allPrice->end_date["value"] >= $prescription_date->format("Y-m-d")) {
                    $price = $allPrice->unit_price;

                    if (in_array($medicine_list->medicine_id, $selected_medicine_ids)) {
                        $medicine_list->update([
                            'status' => 'Diberikan',
                        ]);
                        $totalPrice += ($medicine_list->qty * $price);
                    }

                    $dataMedicines[] = [
                        'id' => $id,
                        'name' => $this->cleanMedicineName($name),
                        'qty' => $medicine_list->qty,
                        'price' => $price,
                        'dosage' => $medicine_list->dosage,
                        'rule' => $medicine_list->rule
                    ];
                }
            }
        }

        $patient_identity = $prescription->encounter->patient->identity;
        $paid_date = now();

        $prescription->encounter->update([
            'status' => 'Sudah Selesai'
        ]);

        $data = [
            'patient_name'          => $prescription->encounter->patient->name,
            'patient_age'           => round($prescription->encounter->patient->birth_date->diffInYears(now())),
            'pharmacist_name'       => $prescription->pharmacist->user->name,
            'medicines'             => $dataMedicines,
            'total_price'           => $totalPrice,
            'paid_date'             => $paid_date,
            'invoice_number'        => $prescription_date->format('Y/m') . '/' . $patient_identity . '/' . $prescription->identity,
        ];

        $prescription->update([
            'total_price' => $totalPrice,
            'paid_date' => $paid_date,
        ]);

        return $this->receipt($data);
    }

    private function receipt($importData)
    {
        $data = [
            'invoice_number'  => $importData['invoice_number'],
            'invoice_date'    => $importData['paid_date'],
            'patient_name'    => $importData['patient_name'],
            'patient_age'     => $importData['patient_age'],
            'medicines'       => $importData['medicines'],
            'total_price'     => $importData['total_price'],
            'pharmacist_name' => $importData['pharmacist_name'],
        ];

        $pdf = Pdf::loadView('layout.components.receipt', $data)
            ->setPaper('A4', 'portrait');
        return $pdf->download('Kwitansi.pdf');
    }

    private function cleanMedicineName($name)
    {
        $name = preg_replace('/\s*\(.*?\)/', '', $name);
        $name = preg_replace('/\b(Tablet|Salut|Selaput)\b/i', '', $name);
        $name = preg_replace('/\s+/', ' ', $name);
        return trim($name);
    }
}
