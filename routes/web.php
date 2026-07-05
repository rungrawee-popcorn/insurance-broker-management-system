<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Company\InsuranceCompanyController;
use App\Http\Controllers\PolicyType\PolicyTypeController;
use App\Http\Controllers\Policy\PolicyController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Report\CustomerReportController;
use App\Http\Controllers\Report\PolicyReportController;

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

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    
    /*
    |--------------------------------------------------------------------------
    | CRUD MODULES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin|agent|staff')->group(function () {

        Route::resource('customers', CustomerController::class);
        Route::resource('companies', InsuranceCompanyController::class);
        Route::resource('policy-types', PolicyTypeController::class);

        /*
        |--------------------------------------------------------------------------
        | Policy Core Module
        |--------------------------------------------------------------------------
        */

        Route::resource('policies', PolicyController::class);

        /*
        |--------------------------------------------------------------------------
        | Renew Policy Feature
        |--------------------------------------------------------------------------
        */

        Route::post('/policies/{id}/renew', [PolicyController::class, 'renew'])
            ->name('policies.renew');

        Route::get('/reports/customers', [CustomerReportController::class, 'index'])
            ->name('reports.customers');

        Route::get('/reports/policies', [PolicyReportController::class, 'index'])
        ->name('reports.policies');
    });

    /*
    |--------------------------------------------------------------------------
    | GLOBAL SEARCH (NEW - SAFE ADDITION)
    |--------------------------------------------------------------------------
    */

    Route::get('/search', [\App\Http\Controllers\Search\SearchController::class, 'index'])
        ->name('search');

});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';