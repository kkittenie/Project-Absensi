<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WaktuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PerizinanController;
use App\Http\Controllers\Admin\KehadiranController;

use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\IzinController;
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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */
        Route::get('/profile', [UserProfileController::class, 'indexAdmin'])->name('profile.index');
        Route::put('/profile', [UserProfileController::class, 'updateAdmin'])->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */
        Route::resource('users', UserController::class);
        Route::put('/users/{uuid}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::put('/users/{uuid}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::delete('/users/{uuid}/remove', [UserController::class, 'remove'])->name('users.remove');

        /*
        |--------------------------------------------------------------------------
        | GURU
        |--------------------------------------------------------------------------
        */
        Route::resource('guru', GuruController::class);
        Route::put('/guru/{uuid}/activate', [GuruController::class, 'activate'])->name('guru.activate');
        Route::put('/guru/{uuid}/deactivate', [GuruController::class, 'deactivate'])->name('guru.deactivate');
        Route::delete('/guru/{uuid}/remove', [GuruController::class, 'remove'])->name('guru.remove');

        /*
        |--------------------------------------------------------------------------
        | WAKTU
        |--------------------------------------------------------------------------
        */
        Route::resource('jam_kehadiran', WaktuController::class)->only(['index', 'update']);
        Route::post('/jam_kehadiran/masuk/{guru}', [WaktuController::class, 'masuk'])->name('jam_kehadiran.masuk');
        Route::post('/jam_kehadiran/pulang/{guru}', [WaktuController::class, 'pulang'])->name('jam_kehadiran.pulang');

        /*
        |--------------------------------------------------------------------------
        | KEHADIRAN
        |--------------------------------------------------------------------------
        */
        Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
        Route::get('/kehadiran/cetak', [KehadiranController::class, 'cetak'])->name('kehadiran.cetak');

        /*
        |--------------------------------------------------------------------------
        | PERIZINAN
        |--------------------------------------------------------------------------
        */
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

        Route::get('/dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | ABSENSI
        |--------------------------------------------------------------------------
        */
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');

        /*
        |--------------------------------------------------------------------------
        | KEHADIRAN
        |--------------------------------------------------------------------------
        */
        Route::get('/kehadiran', [WaktuController::class, 'index'])->name('kehadiran.index');
        Route::post('/kehadiran/masuk/{guru}', [WaktuController::class, 'masuk'])->name('kehadiran.masuk');
        Route::post('/kehadiran/pulang/{guru}', [WaktuController::class, 'pulang'])->name('kehadiran.pulang');

        /*
        |--------------------------------------------------------------------------
        | IZIN
        |--------------------------------------------------------------------------
        */
        Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
        Route::get('/izin/create', [IzinController::class, 'create'])->name('izin.create');
        Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');

        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */
        Route::get('/profile', [UserProfileController::class, 'indexGuru'])->name('profile.index');
        Route::put('/profile', [UserProfileController::class, 'updateGuru'])->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | LOGOUT
        |--------------------------------------------------------------------------
        */
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    });


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';