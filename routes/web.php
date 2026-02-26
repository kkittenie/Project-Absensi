<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PerizinanController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing.index');
})->name('landing.index');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin|superadmin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [UserProfileController::class, 'indexAdmin'])->name('profile.index');
        Route::put('/profile', [UserProfileController::class, 'updateAdmin'])->name('profile.update');

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
        Route::resource('guru', GuruController::class);
        Route::put('/guru/{uuid}/activate', [GuruController::class, 'activate'])->name('guru.activate');
        Route::put('/guru/{uuid}/deactivate', [GuruController::class, 'deactivate'])->name('guru.deactivate');
        Route::delete('/guru/{uuid}/remove', [GuruController::class, 'remove'])->name('guru.remove');

        // Perizinan Management
        Route::get('/perizinan', [PerizinanController::class, 'index'])->name('perizinan.index');
        Route::get('/perizinan/surat/{izin}', [PerizinanController::class, 'surat'])->name('perizinan.surat');
        Route::put('/perizinan/{id}/approve', [PerizinanController::class, 'approve'])->name('perizinan.approve');
        Route::put('/perizinan/{id}/reject', [PerizinanController::class, 'reject'])->name('perizinan.reject');
    });

/*
|--------------------------------------------------------------------------
| Guru Routes
|--------------------------------------------------------------------------
*/
Route::prefix('guru')
    ->middleware('auth:guru')
    ->name('guru.')
    ->group(function () {

        // Absensi
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

        // Izin
        Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
        Route::get('/izin/create', [IzinController::class, 'create'])->name('izin.create');
        Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');

        // Profile
        Route::get('/profile', [UserProfileController::class, 'indexGuru'])->name('profile.index');
        Route::put('/profile', [UserProfileController::class, 'updateGuru'])->name('profile.update');
    });

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';