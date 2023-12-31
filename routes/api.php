<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\FcmNotificationController;
use App\Http\Controllers\API\GeneralController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    // General
    Route::get('lookups', [GeneralController::class, 'lookups']);

    // Auth
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('refresh-token', [UserController::class, 'refreshToken']);
    Route::post('refresh-fcm-token', [FcmNotificationController::class, 'refreshFcmToken']);
    Route::post('forget-password', [UserController::class, '']);
    Route::post('deactivate-account', [UserController::class, '']);
    Route::post('delete-account', [UserController::class, '']);
    Route::post('logout', [UserController::class, 'logout']);

    // Profile
    Route::get('profile/{id?}', [UserController::class, 'profile']);
    Route::put('profile', [UserController::class, 'editProfile']);

    // Notifications
    Route::post('notifications', [FcmNotificationController::class, 'index']);
});
