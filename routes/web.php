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
    return view('welcome');
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
    Route::get('/{any}', function () {
        return view('home');
    });
    // Route::get('/study-plans',[StudyPlanController::class, 'index']);
    // Route::get('/degree-modalities', [DegreeModalityController::class, 'index']);
    // Route::get('/degree-modalities/{id}', [DegreeModalityController::class, 'show']);
    // Route::get('/degree-process-register', [DegreeProcessController::class, 'index']);
    // Route::view('/degree-process-progress', 'requests.progress');
    // Route::view('/protocol-acts', 'layout.content');
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Route::view('/reset-password', 'auth.passwords.reset')->name('reset-password');
});