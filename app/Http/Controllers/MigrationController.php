<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MigrationController extends Controller
{
    public function index(){
        if (!app()->environment(['local', 'staging'])) {
            abort(403, 'Forbidden');
        }

        Artisan::call('migrate', [
            '--seed'  => true,
            '--force' => true,
        ]);

        return response(
            '<pre>' . Artisan::output() . '</pre>'
        );
    }

    public function fresh(){
        if (!app()->environment(['local', 'staging'])) {
            abort(403, 'Forbidden');
        }

        Artisan::call('migrate:fresh', [
            '--seed'  => true,
            '--force' => true,
        ]);

        return response(
            '<pre>' . Artisan::output() . '</pre>'
        );
    }

    public function fresh_seed(){
        if (!app()->environment(['local', 'staging'])) {
            abort(403, 'Forbidden');
        }

        Artisan::call('migrate:fresh --seed', [
            '--seed'  => true,
            '--force' => true,
        ]);

        return response(
            '<pre>' . Artisan::output() . '</pre>'
        );
    }
}
