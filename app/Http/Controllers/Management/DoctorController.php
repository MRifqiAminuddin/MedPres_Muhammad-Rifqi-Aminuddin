<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::select('id', 'name', 'email', 'gender', 'identity')->where('role', 'Dokter')->orderBy('id', 'asc')->get())
                ->addColumn('station', function (User $user) {
                    return $user->doctor->station;
                })
                ->addColumn('action', function (User $user) {
                    return view('layout.components.action', [
                        'name' => $user->name,
                        'identity' => $user->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }

        $stations = [
            'Anak',
            'Anastesi',
            'Andrologi',
            'Bedah Orthopaedi',
            'Bedah Syaraf',
            'Bedah Umum',
            'Bedah Urologi',
            'Gigi dan Mulut',
            'Hamil',
            'Hemodialisis',
            'Jantung',
            'Kandungan',
            'Kulit Kelamin',
            'Mata',
            'Paru',
            'Psikiatri',
            'Psikologi',
            'Rehab Medik',
            'Syaraf',
            'THT',
            'Tumbuh Kembang',
        ];

        return view('management.doctor', compact('stations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Laki Laki', 'Perempuan'])],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'strNumber' => ['required', 'string', 'max:100'],
            'sipNumber' => ['required', 'string', 'max:100'],
            'station' => [
                'required',
                Rule::in([
                    'Anak',
                    'Anastesi',
                    'Andrologi',
                    'Bedah Orthopaedi',
                    'Bedah Syaraf',
                    'Bedah Umum',
                    'Bedah Urologi',
                    'Gigi dan Mulut',
                    'Hamil',
                    'Hemodialisis',
                    'Jantung',
                    'Kandungan',
                    'Kulit Kelamin',
                    'Mata',
                    'Paru',
                    'Psikiatri',
                    'Psikologi',
                    'Rehab Medik',
                    'Syaraf',
                    'THT',
                    'Tumbuh Kembang',
                ]),
            ],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request['name'],
                'role' => 'Dokter',
                'gender' => $request['gender'],
                'email' => $request['email'],
                'identity' => Str::upper(Str::random(10))
            ]);

            $doctor = $user->doctor()->create([
                'str_number' => $request['strNumber'],
                'sip_number' => $request['sipNumber'],
                'station' => $request['station'],
                'identity' => Str::upper(Str::random(10))
            ]);
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil ditambahkan',
        ]);
    }

    public function show(Request $request, string $identity)
    {
        if ($request->ajax()) {
            $user = User::select('id', 'name', 'email', 'gender', 'identity')->where('identity', $identity)->first();
            if ($user) {
                $data = [
                    'status' => 'success',
                    'message' => 'Data berhasil ditemukan',
                    'data' => [
                        'name' => $user->name,
                        'gender' => $user->gender,
                        'email' => $user->email,
                        'str_number' => $user->doctor->str_number,
                        'sip_number' => $user->doctor->sip_number,
                        'station' => $user->doctor->station,
                        'identity' => $user->identity
                    ]
                ];
                return response()->json($data);
            }
        }
    }

    public function update(Request $request, string $identity)
    {
        $user = User::where('identity', $identity)->firstOrFail();

        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'gender'    => ['required', Rule::in(['Laki Laki', 'Perempuan'])],
            'email'     => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'strNumber' => ['required', 'string', 'max:100'],
            'sipNumber' => ['required', 'string', 'max:100'],
            'station' => [
                'required',
                Rule::in([
                    'Anak',
                    'Anastesi',
                    'Andrologi',
                    'Bedah Orthopaedi',
                    'Bedah Syaraf',
                    'Bedah Umum',
                    'Bedah Urologi',
                    'Gigi dan Mulut',
                    'Hamil',
                    'Hemodialisis',
                    'Jantung',
                    'Kandungan',
                    'Kulit Kelamin',
                    'Mata',
                    'Paru',
                    'Psikiatri',
                    'Psikologi',
                    'Rehab Medik',
                    'Syaraf',
                    'THT',
                    'Tumbuh Kembang',
                ]),
            ],
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name'   => $request->name,
                'gender' => $request->gender,
                'email'  => $request->email,
            ]);

            $user->pharmacist()->update([
                'str_number' => $request->strNumber,
                'sip_number' => $request->sipNumber,
                'station' => $request->station,
            ]);
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui',
        ]);
    }

    public function delete(Request $request, string $identity)
    {
        if ($request->ajax()) {
            $user = User::where('identity', $identity)->first();
            $doctorDelete = $user->doctor()->delete();
            $userDelete = $user->delete();
            if ($userDelete && $doctorDelete) {
                $data = [
                    'status' => 'success',
                    'message' => 'Berhasil hapus data'
                ];
                return response()->json($data);
            }
        }
    }
}
