<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\AdminController;

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

            /*
            |--------------------------------------------------------------------------
            | Manajemen Admin
            |--------------------------------------------------------------------------
            */
            Route::prefix('admin')
                ->name('admin.')
                ->group(function (): void {
                    Route::get('/', [AdminController::class, 'index'])
                        ->name('index');
                    Route::post('/', [AdminController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [AdminController::class, 'show'])
                        ->name('show');
                    Route::post('/edit/{identity}', [AdminController::class, 'edit'])
                        ->name('edit');
                    Route::post('/delete/{identity}', [AdminController::class, 'delete'])
                        ->name('delete');
                });

            /*
            |--------------------------------------------------------------------------
            | Manajemen Dokter
            |--------------------------------------------------------------------------
            */
            Route::prefix('dokter')
                ->name('doctor.')
                ->group(function (): void {
                    Route::get('/', [DoctorController::class, 'index'])
                        ->name('index');
                    Route::post('/', [DoctorController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [DoctorController::class, 'show'])
                        ->name('show');
                    Route::post('/edit/{identity}', [DoctorController::class, 'edit'])
                        ->name('edit');
                    Route::post('/delete/{identity}', [DoctorController::class, 'delete'])
                        ->name('delete');
                });

            /*
            |--------------------------------------------------------------------------
            | Manajemen Apoteker
            |--------------------------------------------------------------------------
            */
            Route::prefix('Apoteker')
                ->name('pharmacist.')
                ->group(function (): void {
                    Route::get('/', [PharmacistController::class, 'index'])
                        ->name('index');
                    Route::post('/', [PharmacistController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [PharmacistController::class, 'show'])
                        ->name('show');
                    Route::post('/edit/{identity}', [PharmacistController::class, 'edit'])
                        ->name('edit');
                    Route::post('/delete/{identity}', [PharmacistController::class, 'delete'])
                        ->name('delete');
                });
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
