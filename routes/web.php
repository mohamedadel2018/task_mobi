<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.Dashboard');
});

// Auth::routes();

Route::get('/{all}', function () {
    return view('layouts.Dashboard');
})->where("all", ".*");


Route::get('/dashboard', function () {
    return view('layouts.Dashboard');
});