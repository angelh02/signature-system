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
Route::post('/classification/background/store', 'BackgroundController@store');
Route::post('/classification/background/update', 'BackgroundController@update');
Route::delete('/classification/background/delete/{id}', 'BackgroundController@delete');

//Section routes
Route::get('/classification/section/get-all', 'SectionController@getAll');
Route::get('/classification/section/get/{id}', 'SectionController@getSection');
Route::post('/classification/section/store', 'SectionController@store');
Route::post('/classification/section/update', 'SectionController@update');
Route::delete('/classification/section/delete/{id}', 'SectionController@delete');

//Production area routes
Route::get('/classification/production-area/get-all', 'ProductionAreaController@getAll');
Route::get('/classification/production-area/get/{id}', 'ProductionAreaController@getProductionArea');
Route::post('/classification/production-area/store', 'ProductionAreaController@store');
Route::post('/classification/production-area/update', 'ProductionAreaController@update');
Route::delete('/classification/production-area/delete/{id}', 'ProductionAreaController@delete');

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

//Document Signers routes
Route::post('/document/signer/assign', 'DocumentController@assignSigner');
Route::post('/document/signer/edit', 'DocumentController@editSigner');
Route::delete('/document/signer/delete/{id}', 'DocumentController@deleteSigner');

//Sign Document
Route::post('/document/sign', 'DocumentController@signDocument');