<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Company\InsuranceCompanyController;
use App\Http\Controllers\PolicyType\PolicyTypeController;
use App\Http\Controllers\Policy\PolicyController;

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
| Auth Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Role Dashboards
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->get('/admin/dashboard', fn() => 'Admin Dashboard')->name('admin.dashboard');
    Route::middleware('role:agent')->get('/agent/dashboard', fn() => 'Agent Dashboard')->name('agent.dashboard');
    Route::middleware('role:staff')->get('/staff/dashboard', fn() => 'Staff Dashboard')->name('staff.dashboard');

    /*
    |--------------------------------------------------------------------------
    | CRUD MODULES
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|agent|staff')->group(function () {

        Route::resource('customers', CustomerController::class);
        Route::resource('companies', InsuranceCompanyController::class);
        Route::resource('policy-types', PolicyTypeController::class);

        // Policy Core Module
        Route::resource('policies', PolicyController::class);

        // Renew Policy Feature
        Route::post('/policies/{id}/renew', [PolicyController::class, 'renew'])
            ->name('policies.renew');
    });
});

require __DIR__.'/auth.php';