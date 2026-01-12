<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\User;

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
                    return '
                    <center>
                        <button class="btn bg-gradient-success" style="margin-bottom:0px!important; padding:10px!important" onclick="showEdit(\'' . $user->identity . '\')" >
                            <i class="fa-solid fa-pencil text-white"></i>
                        </button>
                        <button class="btn bg-gradient-danger" style="margin-bottom:0px!important; padding:10px!important" onclick="alertDelete(\'' . $user->name . '\',\'' . $user->identity . '\')" >
                            <i class="fa-solid fa-trash text-white"></i>
                        </button>
                    </center>
                ';
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => [
                'required',
                Rule::in(['Laki', 'Perempuan'])
            ],
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

        if ($validated) {
            $user = User::create([
                'name' => $request['name'],
                'role' => 'Dokter',
                'gender' => $request['gender'],
                'email' => $request['email'],
                'identity' => Str::random(10)
            ]);

            $doctor = $user->doctor()->create([
                'str_number' => $request['strNumber'],
                'sip_number' => $request['sipNumber'],
                'station' => $request['station'],
                'identity' => Str::random(10)
            ]);

            if ($doctor) {
                $data = [
                    'status' => 'success',
                    'message' => 'Berhasil menambah data'
                ];
                return response()->json($data);
            }
        }
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

    public function edit(Request $request, string $identity)
    {
        if ($request->ajax()) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'gender' => [
                    'required',
                    Rule::in(['Laki', 'Perempuan'])
                ],
                'email' => ['required', 'email', 'max:255'],
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

            if ($validated) {
                $user = User::where('identity', $identity)->first();
                if ($user->email == $request['email']) {
                    $userEdit = $user->update([
                        'name' => $request['name'],
                        'role' => 'Dokter',
                        'gender' => $request['gender'],
                        'identity' => Str::random(10)
                    ]);
                } else {
                    $userEdit = $user->update([
                        'name' => $request['name'],
                        'role' => 'Dokter',
                        'gender' => $request['gender'],
                        'email' => $request['email'],
                        'identity' => Str::random(10)
                    ]);
                }

                $doctor = $user->doctor()->update([
                    'str_number' => $request['strNumber'],
                    'sip_number' => $request['sipNumber'],
                    'station' => $request['station'],
                    'identity' => Str::random(10)
                ]);

                if ($doctor && $userEdit) {
                    $data = [
                        'status' => 'success',
                        'message' => 'Berhasil menambah data'
                    ];
                    return response()->json($data);
                }
            }
        }
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
