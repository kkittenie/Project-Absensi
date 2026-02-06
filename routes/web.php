<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing.index');
})->name('landing.index');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| User (Landing + Absensi)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','active'])->group(function () {

    // kalau user buka /dashboard → balik ke landing
    Route::get('/dashboard', function () {
        if(auth()->user()->hasRole('user')){
            return redirect()->route('landing.index');
        }

        return redirect()->route('admin.dashboard');
    });

    // Form absensi (USER)
    Route::get('/absensi', function () {
        return view('absensi.index');
    })->name('absensi.form');

    Route::post('/absensi', [AbsensiController::class, 'store'])
        ->name('absensi.store');
});

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','active','role:superadmin|admin'])
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Profile
    Route::prefix('profile')
        ->name('profile.')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });

    // Users (SUPERADMIN ONLY)
    Route::prefix('users')
        ->name('user.')
        ->middleware('role:superadmin')
        ->controller(UserController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store')->name('store');
            Route::get('/edit/{uuid}', 'edit')->name('edit');
            Route::put('/edit/{uuid}', 'update')->name('update');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
            Route::put('/deactivate/{uuid}', 'deactivate')->name('deactivate');
            Route::delete('/{uuid}', 'remove')->name('remove');
        });

    // Guru (SUPERADMIN)
    Route::prefix('gurus')
        ->name('guru.')
        ->middleware('role:superadmin')
        ->controller(GuruController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/create', 'store')->name('store');
            Route::get('/edit/{uuid}', 'edit')->name('edit');
            Route::put('/edit/{uuid}', 'update')->name('update');
            Route::put('/activate/{uuid}', 'activate')->name('activate');
            Route::put('/deactivate/{uuid}', 'deactivate')->name('deactivate');
            Route::delete('/{uuid}', 'remove')->name('remove');
        });

    // Absensi ADMIN
    Route::prefix('absensis')
        ->name('absensi.')
        ->controller(AbsensiController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{uuid}', 'show')->name('show');
        });
});
