<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;

//Landing Page
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

//Admin Page
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard.index');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:superadmin|admin')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            //Profile
            Route::prefix('profile')
                ->name('profile.')
                ->controller(ProfileController::class)
                ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/', 'update')->name('update');
            });

            //Users
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
        });
});
