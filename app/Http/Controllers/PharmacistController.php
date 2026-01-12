<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\User;

class PharmacistController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::select('id', 'name', 'email', 'gender', 'identity')->where('role', 'Apoteker')->orderBy('id', 'asc')->get())
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
        return view('management.pharmacist');
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
        ]);

        if ($validated) {
            $user = User::create([
                'name' => $request['name'],
                'role' => 'Apoteker',
                'gender' => $request['gender'],
                'email' => $request['email'],
                'identity' => Str::random(10)
            ]);

            $pharmacist = $user->pharmacist()->create([
                'str_number' => $request['strNumber'],
                'identity' => Str::random(10)
            ]);

            if ($pharmacist) {
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
                        'str_number' => $user->pharmacist->str_number,
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
            ]);

            if ($validated) {
                $user = User::where('identity', $identity)->first();
                if ($user->email == $request['email']) {
                    $userEdit = $user->update([
                        'name' => $request['name'],
                        'role' => 'Apoteker',
                        'gender' => $request['gender'],
                        'identity' => Str::random(10)
                    ]);
                } else {
                    $userEdit = $user->update([
                        'name' => $request['name'],
                        'role' => 'Apoteker',
                        'gender' => $request['gender'],
                        'email' => $request['email'],
                        'identity' => Str::random(10)
                    ]);
                }

                $pharmacist = $user->pharmacist()->update([
                    'str_number' => $request['strNumber'],
                    'identity' => Str::random(10)
                ]);

                if ($pharmacist && $userEdit) {
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
            $pharmacistDelete = $user->pharmacist()->delete();
            $userDelete = $user->delete();
            if ($userDelete && $pharmacistDelete) {
                $data = [
                    'status' => 'success',
                    'message' => 'Berhasil hapus data'
                ];
                return response()->json($data);
            }
        }
    }
}
