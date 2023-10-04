<?php

use Illuminate\Support\Facades\Route;

// Lang (put this in middleware "Localization Middleware")
Route::get('ar', function () {
    session(['locale' => 'ar']);
    return back();
})->name('ar');

Route::get('en', function () {
    session(['locale' => 'en']);
    return back();
})->name('en');

Route::view('/', 'landing.index');
