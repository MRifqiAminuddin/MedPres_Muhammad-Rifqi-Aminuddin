<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MigrationController;

/*
|--------------------------------------------------------------------------
| Authentication (Autentikasi)
|--------------------------------------------------------------------------
*/

Route::name('auth.')
    ->group(function (): void {
        Route::get('masuk', [AuthController::class, 'loginIndex'])
            ->name('login.index');

        Route::post('masuk', [AuthController::class, 'loginProcess'])
            ->name('login.process');

        Route::get('keluar', [AuthController::class, 'logout'])
            ->name('logout');

        Route::get('verifikasi', [AuthController::class, 'verificationIndex'])
            ->name('verification.index');
    });


/*
|--------------------------------------------------------------------------
| Wajib Login
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth'], function () {
    /*
    |--------------------------------------------------------------------------
    | Dasbor
    |--------------------------------------------------------------------------
    */
    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    Route::get('/dasbor', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    Route::prefix('manajemen')
        ->name('management.')
        ->group(function (): void {
            Route::get('/dokter', [DoctorController::class, 'index'])
                ->name('doctor.index');
        });
});


/*
|--------------------------------------------------------------------------
| Migration
|--------------------------------------------------------------------------
*/
Route::prefix('migration')
    ->name('migration.')
    ->group(function (): void {
        Route::get('/', [MigrationController::class, 'index'])
            ->name('index');

        Route::get('fresh', [MigrationController::class, 'fresh'])
            ->name('fresh');

        Route::get('fresh-seed', [MigrationController::class, 'freshSeed'])
            ->name('fresh.seed');
    });
