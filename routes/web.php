<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MigrationController;

Route::get('/', function () {
    return view('welcome');
});

// Kelola migration
Route::prefix('migration')->group(function () {
    Route::get('/', [MigrationController::class, 'index'])->name('migration.index');
    Route::get('/fresh', [MigrationController::class, 'fresh'])->name('migration.fresh');
    Route::get('/fresh-seed', [MigrationController::class, 'freshSeed'])->name('migration.freshSeed');
});
