<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class MigrationController extends Controller
{
    public function index()
    {
        $this->ensureAllowedEnvironment();

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        return $this->artisanResponse();
    }

    public function fresh()
    {
        $this->ensureAllowedEnvironment();

        Artisan::call('migrate:fresh', [
            '--force' => true,
        ]);

        return $this->artisanResponse();
    }

    public function freshSeed()
    {
        $this->ensureAllowedEnvironment();

        Artisan::call('migrate:fresh', [
            '--seed'  => true,
            '--force' => true,
        ]);

        return $this->artisanResponse();
    }

    private function ensureAllowedEnvironment(): void
    {
        if (!app()->environment(['local', 'staging'])) {
            abort(403, 'Forbidden');
        }
    }

    private function artisanResponse()
    {
        return response('<pre>' . e(Artisan::output()) . '</pre>');
    }
}