<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\PerizinanController;
use Illuminate\Support\Facades\Route;

//Landing
Route::get('/', function () {
    return view('landing.index');
})->name('landing.index');

//Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

//Authenticated
Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard.index');

    //Admin Area
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:superadmin|admin')
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

            // Users
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

            //Perizinan Guru (ADMIN)
            Route::prefix('perizinan')
                ->name('perizinan.')
                ->controller(PerizinanController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/surat/{izin}', 'surat')->name('surat');
                    Route::put('/{izin}/approve', 'approve')->name('approve');
                    Route::put('/{izin}/reject', 'reject')->name('reject');
                });
        });

    //Izin Guru (Guru)
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::get('/izin/create', [IzinController::class, 'create'])->name('izin.create');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');
});
