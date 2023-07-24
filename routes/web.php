<?php

use Illuminate\Support\Facades\Route;

// Lang
Route::get('ar', function() {
    session(['locale' => 'ar']);
    return back();
})->name('ar');

Route::get('en', function() {
    session(['locale' => 'en']);
    return back();
})->name('en');

Route::get('/', function(){
    return 'Home page';
    // test
});
