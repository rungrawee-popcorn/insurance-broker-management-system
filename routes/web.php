<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CustomerController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard (Breeze default)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile Management
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Role-based Dashboards
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return 'Admin Dashboard';
        })->name('admin.dashboard');
    });

    Route::middleware('role:agent')->group(function () {
        Route::get('/agent/dashboard', function () {
            return 'Agent Dashboard';
        })->name('agent.dashboard');
    });

    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/dashboard', function () {
            return 'Staff Dashboard';
        })->name('staff.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer Management (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|agent|staff')->group(function () {
        Route::resource('customers', CustomerController::class);
    });

});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';