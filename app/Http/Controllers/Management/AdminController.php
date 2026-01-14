<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\User;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::select('id', 'name', 'email', 'gender', 'identity')->where('role', 'Admin')->orderBy('id', 'asc')->get())
                ->addColumn('action', function (User $user) {
                    return view('layout.components.action', [
                        'name' => $user->name,
                        'identity' => $user->identity,
                    ])->render();
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('management.admin');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Laki Laki', 'Perempuan'])],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'role'     => 'Admin',
            'gender'   => $validated['gender'],
            'email'    => $validated['email'],
            'identity' => Str::upper(Str::random(10)),
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

        $user = User::select('id', 'name', 'email', 'gender', 'identity')
            ->where('identity', $identity)
            ->firstOrFail();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data apoteker berhasil diperbarui',
            'data'    => [
                'name'     => $user->name,
                'gender'   => $user->gender,
                'email'    => $user->email,
                'identity' => $user->identity,
            ],
        ]);
    }


    public function update(Request $request, string $identity)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $user = User::where('identity', $identity)->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(['Laki Laki', 'Perempuan'])],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update([
            'name'   => $validated['name'],
            'gender' => $validated['gender'],
            'email'  => $validated['email'],
            'role'   => 'Admin',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui',
        ]);
    }


    public function delete(Request $request, string $identity)
    {
        if ($request->ajax()) {
            $user = User::where('identity', $identity)->firstOrFail();
            $user->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
        }
    }
}
