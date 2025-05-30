<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TamuController;


Route::get('/', function () {
    return view('main');
})->name('home');

Route::post('/', [TamuController::class, 'storeFromMain'])->name('main');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/laporan', [DashboardController::class, 'laporan'])
    ->middleware(['auth', 'verified'])
    ->name('laporan');

Route::get('/laporan/export', [DashboardController::class, 'exportLaporan'])
    ->middleware(['auth', 'verified'])
    ->name('laporan.export');

Route::get('/tamu-details/{id}', [TamuController::class, 'getDetails'])
    ->middleware(['auth', 'verified'])
    ->name('tamu.details');

Route::resource('tamu', TamuController::class)
    ->middleware(['auth', 'verified'])
    ->names('admin.tamu');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
