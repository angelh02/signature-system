<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::view('/{any}','home')
//     ->middleware(['auth'])
//     ->where('any','.*');
    
Route::middleware(['auth'])->group(function() {
    // Route::view('/', 'layout.content');
    // Route::view('/reset-password', 'auth.passwords.reset')->name('reset-password');
    // Route::post('/reset-password', [ResetPasswordController::class, 'resetUserPassword'])->name('reset-password');
    // Route::get('/{any}', function () {
    //     return view('home');
    // });
    Route::view('/{any}','home')
    ->middleware(['auth'])
    ->where('any','.*');
});