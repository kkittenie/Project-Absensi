<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WaktuController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing.index');
})->name('landing.index');


/*
|--------------------------------------------------------------------------
| ADMIN
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
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{uuid}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{uuid}', [UserController::class, 'update'])->name('users.update');
        Route::put('/users/{uuid}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::put('/users/{uuid}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::delete('/users/{uuid}', [UserController::class, 'remove'])->name('users.remove');


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
    });



/*
|--------------------------------------------------------------------------
| GURU
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
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';