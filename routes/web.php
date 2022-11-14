<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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
Route::get('/login-google', [AuthController::class, 'googleLogin']);
Route::get('/google-callback', [AuthController::class, 'googleCallback']);
//Route::view('/email-test', 'email.document-to-sign');
//Route::view('/email-test1', 'email.notification-signer');

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
        Route::view('/mis-documentos/estado/{id}','home')->where('id', '[0-9]+');
        Route::view('/mis-documentos/detalles/{id}','home')->where('id', '[0-9]+');
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