<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PharmacistController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::select('id', 'name', 'email', 'gender', 'identity')->where('role', 'Apoteker')->orderBy('id', 'asc')->get())
                ->addColumn('action', function (User $user) {
                    return view('layout.components.action', [
                        'name' => $user->name,
                        'identity' => $user->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('management.pharmacist');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'gender'    => ['required', Rule::in(['Laki Laki', 'Perempuan'])],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'strNumber' => ['required', 'string', 'max:100'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'role'     => 'Apoteker',
                'gender'   => $request->gender,
                'email'    => $request->email,
                'identity' => Str::upper(Str::random(10)),
            ]);

            $user->pharmacist()->create([
                'str_number' => $request->strNumber,
                'identity'   => Str::upper(Str::random(10)),
            ]);
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Data apoteker berhasil ditambahkan',
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
                        'str_number' => $user->pharmacist->str_number,
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
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name'   => $request->name,
                'gender' => $request->gender,
                'email'  => $request->email,
            ]);

            $user->pharmacist()->update([
                'str_number' => $request->strNumber,
            ]);
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Data apoteker berhasil diperbarui',
        ]);
    }


    public function delete(Request $request, string $identity)
    {
        if ($request->ajax()) {
            $user = User::where('identity', $identity)->firstOrFail();
            $pharmacistDelete = $user->pharmacist()->delete();
            $userDelete = $user->delete();
            if ($userDelete && $pharmacistDelete) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Data berhasil dihapus',
                ]);
            }
        }
    }
}
