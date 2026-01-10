<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MigrationController;

/*
|--------------------------------------------------------------------------
| Authentication (Autentikasi)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')
    ->name('auth.')
    ->group(function (): void {
        Route::get('login', [AuthController::class, 'loginIndex'])
            ->name('login.index');

        Route::post('login', [AuthController::class, 'loginProcess'])
            ->name('login.process');

        Route::post('logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

/*
|--------------------------------------------------------------------------
| Beranda
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');


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
