<?php

use App\Http\Middleware\hasRole;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ArtisanController;

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

    Route::middleware(['auth', 'hasRole:Admin'])
        ->prefix('manajemen')
        ->name('management.')
        ->group(function () {

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
                    Route::post('/edit/{identity}', [AdminController::class, 'update'])
                        ->name('update');
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
                    Route::post('/edit/{identity}', [DoctorController::class, 'update'])
                        ->name('update');
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
                    Route::post('/edit/{identity}', [PharmacistController::class, 'update'])
                        ->name('update');
                    Route::post('/delete/{identity}', [PharmacistController::class, 'delete'])
                        ->name('delete');
                });

            /*
            |--------------------------------------------------------------------------
            | Manajemen Pasien
            |--------------------------------------------------------------------------
            */
            Route::prefix('Pasien')
                ->name('patient.')
                ->group(function (): void {
                    Route::get('/', [PatientController::class, 'index'])
                        ->name('index');
                    Route::post('/', [PatientController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [PatientController::class, 'show'])
                        ->name('show');
                    Route::post('/edit/{identity}', [PatientController::class, 'update'])
                        ->name('update');
                    Route::post('/delete/{identity}', [PatientController::class, 'delete'])
                        ->name('delete');
                });
        });

    /*
    |--------------------------------------------------------------------------
    | Artisan
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'hasRole:Admin'])
        ->prefix('artisan')
        ->name('artisan.')
        ->group(function () {

            Route::get('/migrate', [ArtisanController::class, 'index']);
            Route::get('/migrate-fresh', [ArtisanController::class, 'fresh']);
            Route::get('/migrate-fresh-seed', [ArtisanController::class, 'freshSeed']);
            Route::get('/config-clear', [ArtisanController::class, 'configClear']);
            Route::get('/config-cache', [ArtisanController::class, 'configCache']);
        });
});
