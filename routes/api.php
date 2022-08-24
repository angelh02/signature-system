<?php

use App\Http\Controllers\BackgroundController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Background routes
Route::get('/classification/background/get-all', 'BackgroundController@getAll');
Route::get('/classification/background/get/{id}', 'BackgroundController@getBackground');

//Section routes
Route::get('/classification/section/get-all', 'SectionController@getAll');
Route::get('/classification/section/get/{id}', 'SectionController@getSection');

//Section routes
Route::get('/classification/production-area/get-all', 'ProductionAreaController@getAll');
Route::get('/classification/production-area/get/{id}', 'ProductionAreaController@getSection');

//Classification routes
Route::get('/classification/get-all', 'ClassificationController@getAll');
Route::get('/classification/get/{id}', 'ClassificationController@getClassification');
Route::post('/classification/store', 'ClassificationController@store');
Route::post('/classification/update', 'ClassificationController@update');
Route::delete('/classification/delete/{id}', 'ClassificationController@delete');
