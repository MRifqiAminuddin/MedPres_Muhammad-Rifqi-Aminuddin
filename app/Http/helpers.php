<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('hasRole')) {
    function hasRole($role)
    {
        $user = Auth::user();
        return $user && $user->role->contains('name', $role);
    }
}
