<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WaktuController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| LANDING
=======
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
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
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
<<<<<<< HEAD
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */
        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile.index');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */
=======
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [UserProfileController::class, 'indexAdmin'])->name('profile.index');
        Route::put('/profile', [UserProfileController::class, 'updateAdmin'])->name('profile.update');

        // User Management
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{uuid}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{uuid}', [UserController::class, 'update'])->name('users.update');
        Route::put('/users/{uuid}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::put('/users/{uuid}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::delete('/users/{uuid}', [UserController::class, 'remove'])->name('users.remove');

<<<<<<< HEAD

        /*
        |--------------------------------------------------------------------------
        | GURU (FULL CRUD)
        |--------------------------------------------------------------------------
        */
        Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/guru/{uuid}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/guru/{uuid}', [GuruController::class, 'update'])->name('guru.update');
        Route::put('/guru/{uuid}/activate', [GuruController::class, 'activate'])->name('guru.activate');
        Route::put('/guru/{uuid}/deactivate', [GuruController::class, 'deactivate'])->name('guru.deactivate');
        Route::delete('/guru/{uuid}', [GuruController::class, 'destroy'])->name('guru.remove');


        /*
        |--------------------------------------------------------------------------
        | WAKTU / KEHADIRAN (ADMIN CONTROL)
        |--------------------------------------------------------------------------
        */
        Route::get('/waktu', [WaktuController::class, 'index'])
            ->name('waktu.index');

        Route::post('/waktu/masuk/{guru}', [WaktuController::class, 'masuk'])
            ->name('waktu.masuk');

        Route::post('/waktu/pulang/{guru}', [WaktuController::class, 'pulang'])
            ->name('waktu.pulang');
=======
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
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
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

<<<<<<< HEAD
        // Dashboard
        Route::get('/dashboard', function () {
            return view('guru.dashboard');
        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | ABSENSI
        |--------------------------------------------------------------------------
        */
        Route::get('/absensi', [AbsensiController::class, 'index'])
            ->name('absensi.index');

        Route::get('/absensi/create', [AbsensiController::class, 'create'])
            ->name('absensi.create');

        Route::post('/absensi', [AbsensiController::class, 'store'])
            ->name('absensi.store');


        /*
        |--------------------------------------------------------------------------
        | KEHADIRAN / WAKTU (GURU SELF)
        |--------------------------------------------------------------------------
        */
        Route::get('/kehadiran', [WaktuController::class, 'index'])
            ->name('kehadiran.index');

        Route::post('/kehadiran/masuk/{guru}', [WaktuController::class, 'masuk'])
            ->name('kehadiran.masuk');

        Route::post('/kehadiran/pulang/{guru}', [WaktuController::class, 'pulang'])
            ->name('kehadiran.pulang');


        // Logout Guru
        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout');
    });


/*
|--------------------------------------------------------------------------
| AUTH
=======
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
>>>>>>> e089b05499cbd155a4be97c6a4336bffa879b434
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';