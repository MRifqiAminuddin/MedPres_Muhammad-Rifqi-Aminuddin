<?php

use App\Http\Middleware\HasRole;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Management\DoctorController;
use App\Http\Controllers\Management\PharmacistController;
use App\Http\Controllers\Management\AdminController;
use App\Http\Controllers\Management\PatientController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\EncounterController;
use App\Http\Controllers\ConsultationController;

// Autentikasi
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


// Wajib login
Route::group(['middleware' => 'auth'], function () {

    // Dasbor
    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    Route::get('/dasbor', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    // Kunjungan
    Route::middleware(['auth', HasRole::class . ':Admin'])
        ->prefix('kunjungan')
        ->name('encounter.')
        ->group(function () {
            Route::get('/', [EncounterController::class, 'index'])
                ->name('index');
            Route::post('/', [EncounterController::class, 'store'])
                ->name('store');
            Route::post('/show/{identity}', [EncounterController::class, 'show'])
                ->name('show');
            Route::post('/update/{identity}', [EncounterController::class, 'update'])
                ->name('update');
            Route::post('/delete/{identity}', [EncounterController::class, 'delete'])
                ->name('delete');
            Route::post('/panggil/{identity}', [EncounterController::class, 'call'])
                ->name('call');
            Route::get('/cari-pasien', [EncounterController::class, 'searchPatient'])
                ->name('search.patient');
            Route::get('/cari-dokter', [EncounterController::class, 'searchDoctor'])
                ->name('search.doctor');
        });


    // Konsultasi
    Route::middleware(['auth', HasRole::class . ':Dokter'])
        ->prefix('konsultasi')
        ->name('consultation.')
        ->group(function () {
            Route::get('/', [ConsultationController::class, 'index'])
                ->name('index');
            // Route::post('/', [ConsultationController::class, 'store'])
            //     ->name('store');
            // Route::post('/show/{identity}', [ConsultationController::class, 'show'])
            //     ->name('show');
            // Route::post('/update/{identity}', [ConsultationController::class, 'update'])
            //     ->name('update');
            // Route::post('/delete/{identity}', [ConsultationController::class, 'delete'])
            //     ->name('delete');
            // Route::post('/panggil/{identity}', [ConsultationController::class, 'call'])
            //     ->name('call');
            // Route::get('/cari-pasien', [ConsultationController::class, 'searchPatient'])
            //     ->name('search.patient');
            // Route::get('/cari-dokter', [ConsultationController::class, 'searchDoctor'])
            //     ->name('search.doctor');
        });

    // Menu manajemen
    Route::middleware(['auth', HasRole::class . ':Super Admin'])
        ->prefix('manajemen')
        ->name('management.')
        ->group(function () {

            // Manajemen Admin
            Route::prefix('admin')
                ->name('admin.')
                ->group(function (): void {
                    Route::get('/', [AdminController::class, 'index'])
                        ->name('index');
                    Route::post('/', [AdminController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [AdminController::class, 'show'])
                        ->name('show');
                    Route::post('/update/{identity}', [AdminController::class, 'update'])
                        ->name('update');
                    Route::post('/delete/{identity}', [AdminController::class, 'delete'])
                        ->name('delete');
                });

            // Manajemen Dokter
            Route::prefix('dokter')
                ->name('doctor.')
                ->group(function (): void {
                    Route::get('/', [DoctorController::class, 'index'])
                        ->name('index');
                    Route::post('/', [DoctorController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [DoctorController::class, 'show'])
                        ->name('show');
                    Route::post('/update/{identity}', [DoctorController::class, 'update'])
                        ->name('update');
                    Route::post('/delete/{identity}', [DoctorController::class, 'delete'])
                        ->name('delete');
                });

            // Manajemen Apoteker
            Route::prefix('Apoteker')
                ->name('pharmacist.')
                ->group(function (): void {
                    Route::get('/', [PharmacistController::class, 'index'])
                        ->name('index');
                    Route::post('/', [PharmacistController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [PharmacistController::class, 'show'])
                        ->name('show');
                    Route::post('/update/{identity}', [PharmacistController::class, 'update'])
                        ->name('update');
                    Route::post('/delete/{identity}', [PharmacistController::class, 'delete'])
                        ->name('delete');
                });

            // Manajemen Pasien
            Route::prefix('Pasien')
                ->name('patient.')
                ->group(function (): void {
                    Route::get('/', [PatientController::class, 'index'])
                        ->name('index');
                    Route::post('/', [PatientController::class, 'store'])
                        ->name('store');
                    Route::post('/show/{identity}', [PatientController::class, 'show'])
                        ->name('show');
                    Route::post('/update/{identity}', [PatientController::class, 'update'])
                        ->name('update');
                    Route::post('/delete/{identity}', [PatientController::class, 'delete'])
                        ->name('delete');
                });
        });

    // Artisan
    Route::middleware(['auth', HasRole::class . ':Super Admin'])
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
