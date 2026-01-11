<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginIndex()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        } else {
            return view('auth.login');
        }
    }

    public function loginProcess()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        } else {
            $attributes = request()->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt($attributes)) {

                session()->regenerate();
                return redirect()->route('dashboard.index')->with(['success' => 'Hai ' . Auth::user()->name . '! Selamat datang kembali.']);
            } else {

                return back()->withErrors(['email' => 'Email atau password salah.']);
            }
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            $name = Auth::user()->name;
            Auth::logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return redirect()
                ->route('auth.login.index')
                ->with('success', 'Hai ' . $name . '! Sampai jumpa kembali.');
        } else {
            return redirect()->route('auth.login.index');
        }
    }

    public function verificationIndex()
    {
        return view('auth.verification');
    }
}
