<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware([])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth:admin');

    // Admins
    Route::get('admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('admins/store', [AdminController::class, 'store'])->name('admins.store');
    Route::get('admins/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::post('admins/update', [AdminController::class, 'update'])->name('admins.update');
    Route::get('admins/{id}', [AdminController::class, 'show'])->name('admins.show');

    // Customers
    Route::get('users', [UserContr::class, 'list'])->name('users');
    Route::get('users/create', [AdminController::class, 'create'])->name('create');
    Route::post('users/create', [AdminController::class, 'store'])->name('users.store');
    // Route::get('customers/{id}', [UserManagementController::class, 'show'])->name('show');
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
