<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('landing.index');
})->name('landing.index');

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin|superadmin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Profile Management
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{uuid}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{uuid}', [UserController::class, 'update'])->name('users.update');
        Route::put('/users/{uuid}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::put('/users/{uuid}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::delete('/users/{uuid}', [UserController::class, 'remove'])->name('users.remove');

        // Guru Management
        Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/guru/{guru}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/guru/{guru}', [GuruController::class, 'update'])->name('guru.update');
        Route::put('/guru/{guru}/activate', [GuruController::class, 'activate'])->name('guru.activate');
        Route::put('/guru/{guru}/deactivate', [GuruController::class, 'deactivate'])->name('guru.deactivate');
        Route::delete('/guru/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
        Route::delete('/guru/{uuid}/remove', [GuruController::class, 'remove'])->name('guru.remove');
    });

/*
|--------------------------------------------------------------------------
| GURU Routes
|--------------------------------------------------------------------------
*/

Route::prefix('guru')
    ->middleware('auth:guru')
    ->name('guru.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');

        // Absensi
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

        // Logout
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

/*
|--------------------------------------------------------------------------
| Absensi Routes (Public Access - Tanpa Prefix)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:guru')->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
});

/*
|--------------------------------------------------------------------------
| Logout Route (Accessible from anywhere)
|--------------------------------------------------------------------------
*/

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, etc.)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';