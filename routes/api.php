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

//Classification form routes
//Background routes
Route::get('/classification/background/get-all', 'BackgroundController@getAll');
Route::get('/classification/background/get/{id}', 'BackgroundController@getBackground');

//Section routes
Route::get('/classification/section/get-all', 'SectionController@getAll');
Route::get('/classification/section/get/{id}', 'SectionController@getSection');

//Production area routes
Route::get('/classification/production-area/get-all', 'ProductionAreaController@getAll');
Route::get('/classification/production-area/get/{id}', 'ProductionAreaController@getProductionArea');

//Classification routes
Route::get('/classification/get-all', 'ClassificationController@getAll');
Route::get('/classification/get/{id}', 'ClassificationController@getClassification');
Route::post('/classification/store', 'ClassificationController@store');
Route::post('/classification/update', 'ClassificationController@update');
Route::delete('/classification/delete/{id}', 'ClassificationController@delete');

//Containers form routes
//Conservation times routes
Route::get('/container/conservation-time/get-all', 'ConservationTimeController@getAll');
Route::get('/container/conservation-time/get/{id}', 'ConservationTimeController@getConservationTime');

//Conservation types routes
Route::get('/container/conservation-type/get-all', 'ConservationTypeController@getAll');
Route::get('/container/conservation-type/get/{id}', 'ConservationTypeController@getConservationType');

//Document values routes
Route::get('/container/document-value/get-all', 'DocumentValueController@getAll');
Route::get('/container/document-value/get/{id}', 'DocumentValueController@getDocumentValue');

//Information types routes
Route::get('/container/information-type/get-all', 'InformationTypeController@getAll');
Route::get('/container/information-type/get/{id}', 'InformationTypeController@getInformationType');

//Selection techniques routes
Route::get('/container/selection-technique/get-all', 'SelectionTechniqueController@getAll');
Route::get('/container/selection-technique/get/{id}', 'SelectionTechniqueController@getSelectionTechnique');

//Container routes
Route::get('/container/get-all', 'ContainerController@getAll');
Route::get('/container/get/{id}', 'ContainerController@getContainer');
Route::post('/container/store', 'ContainerController@store');
Route::post('/container/update', 'ContainerController@update');
Route::delete('/container/delete/{id}', 'ContainerController@delete');

//Document Types routes
Route::get('/document-type/get-all', 'DocumentTypeController@getAll');
Route::get('/document-type/get/{id}', 'DocumentTypeController@getDocumentType');

//Container routes
Route::get('/document/get-all', 'DocumentController@getAll');
Route::get('/document/get/{id}', 'DocumentController@getDocument');
Route::post('/document/store', 'DocumentController@store');
Route::post('/document/update', 'DocumentController@update');
Route::delete('/document/delete/{id}', 'DocumentController@delete');
