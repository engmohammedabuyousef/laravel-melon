<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth:admin');

    // Admins
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('create', [AdminController::class, 'create'])->name('create');
        Route::post('store', [AdminController::class, 'store'])->name('store');
        Route::get('{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [AdminController::class, 'update'])->name('update');
        Route::get('{id}', [AdminController::class, 'show'])->name('show');
    });

    // Roles
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('create', [RoleController::class, 'create'])->name('create');
        Route::post('store', [RoleController::class, 'store'])->name('store');
        Route::get('{id}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [RoleController::class, 'update'])->name('update');
        Route::get('{id}', [RoleController::class, 'show'])->name('show');
    });

    // Permissions
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('create', [AdminController::class, 'create'])->name('create');
        Route::post('store', [AdminController::class, 'store'])->name('store');
        Route::get('{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [AdminController::class, 'update'])->name('update');
        Route::get('{id}', [AdminController::class, 'show'])->name('show');
    });

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('{id}/update', [UserController::class, 'update'])->name('update');
        Route::post('{id}/delete', [UserController::class, 'destroy'])->name('destroy');
        Route::get('{id}', [UserController::class, 'show'])->name('show');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('create', [NotificationController::class, 'create'])->name('create');
        Route::post('store', [NotificationController::class, 'store'])->name('store');
    });
});

Route::get('/error', function () {
    abort(500);
});

require __DIR__ . '/admin-auth.php';
