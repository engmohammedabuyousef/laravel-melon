<?php

use App\Http\Controllers\Apps\AdminController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware([])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth:admin');

    Route::resource('users', UserManagementController::class);

    // Admins
    Route::get('admins', [AdminController::class, 'list'])->name('admins');
    // Route::get('admins-data', [AdminController::class, 'adminsData']);
    // Route::get('admins/{id}', [AdminController::class, 'show'])->name('show');
    // Route::get('admins/create', [AdminController::class, 'create'])->name('create');

    // Customers
    Route::get('customers', [UserManagementController::class, 'list'])->name('customers');
    // Route::get('customers-data', [UserManagementController::class, 'customersData']);
    Route::get('customers/create', [AdminController::class, 'create'])->name('create');
    Route::post('customers/create', [AdminController::class, 'store'])->name('customers.store');
    // Route::get('customers/{id}', [UserManagementController::class, 'show'])->name('show');

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
