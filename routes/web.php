<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/streaming', function () {
    return view('pages/streaming');
});

Route::get('/start', function () {
    return view('pages/fitness');
});

Route::get('/fitness', function () {
    return view('pages/fitness');
});

Route::get('/lastfm', function () {
    return view('pages/lastfm');
});

Route::get('/signin', function () {
    return view('auth/signin');
});

Route::get('/spotify', function () {
    return view('auth/spotify');
});

Route::get('/stravaSignIn', function () {
    return view('auth/stravaSignIn');
});

Route::get('/stravaAuth', function () {
    return view('auth/stravaAuth');
});

Route::get('/test', function () {
    return view('pages/test');
});

Route::get('/run', function () {
    return view('pages/run');
});

Route::get('/information', function () {
    return view('pages/information');
});
