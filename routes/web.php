<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::view('/{any}','home')
//     ->middleware(['auth'])
//     ->where('any','.*');
    
Route::middleware(['auth'])->group(function() {
    // Route::view('/', 'layout.content');
    Route::view('/reset-password', 'auth.passwords.reset')->name('reset-password');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetUserPassword'])->name('reset-password');
    // Route::get('/{any}', function () {
    //     return view('home');
    // });
    Route::get('/', [HomeController::class, 'index']);
    Route::group(['middleware' => ['role:Firmante']], function () {
        Route::view('/mis-documentos','home');
        Route::view('/clasificaciones-archivisticas','home');
        Route::view('/contenedores','home');
    });
    Route::group(['middleware' => ['role:Administrador']], function () {
        Route::view('/solicitudes','admin.index');
        Route::view('/usuarios','admin.index');
        Route::view('/catalogo/{any}','admin.index')->where('any', '.*');
    });
    // Route::view('/reset-password', 'auth.passwords.reset')->name('reset-password');

    
    Route::any('{url}', function(){
        return redirect('/');
    })->where('url', '.*');
});