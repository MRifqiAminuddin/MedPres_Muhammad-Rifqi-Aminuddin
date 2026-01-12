<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasRole
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        // Loop untuk memeriksa setiap permission yang diberikan
        if (Auth::check()) {
            if (Auth::user()->role == $role[0]) {
                return $next($request);
            } else {
                return redirect()->route('dashboard.index')->with('fail', "Akses tidak sah");
            }
        } else {
            return redirect()->route('auth.login.index')->with('fail', "Mohon login terlebih dahulu");
        }
    }
}
