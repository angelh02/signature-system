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
Route::post('/container/conservation-time/store', 'ConservationTimeController@store');
Route::post('/container/conservation-time/update', 'ConservationTimeController@update');
Route::delete('/container/conservation-time/delete/{id}', 'ConservationTimeController@delete');

//Conservation types routes
Route::get('/container/conservation-type/get-all', 'ConservationTypeController@getAll');
Route::get('/container/conservation-type/get/{id}', 'ConservationTypeController@getConservationType');
Route::post('/container/conservation-type/store', 'ConservationTypeController@store');
Route::post('/container/conservation-type/update', 'ConservationTypeController@update');
Route::delete('/container/conservation-type/delete/{id}', 'ConservationTypeController@delete');

//Document values routes
Route::get('/container/document-value/get-all', 'DocumentValueController@getAll');
Route::get('/container/document-value/get/{id}', 'DocumentValueController@getDocumentValue');
Route::post('/container/document-value/store', 'DocumentValueController@store');
Route::post('/container/document-value/update', 'DocumentValueController@update');
Route::delete('/container/document-value/delete/{id}', 'DocumentValueController@delete');

//Information types routes
Route::get('/container/information-type/get-all', 'InformationTypeController@getAll');
Route::get('/container/information-type/get/{id}', 'InformationTypeController@getInformationType');
Route::post('/container/information-type/store', 'InformationTypeController@store');
Route::post('/container/information-type/update', 'InformationTypeController@update');
Route::delete('/container/information-type/delete/{id}', 'InformationTypeController@delete');

//Selection techniques routes
Route::get('/container/selection-technique/get-all', 'SelectionTechniqueController@getAll');
Route::get('/container/selection-technique/get/{id}', 'SelectionTechniqueController@getSelectionTechnique');
Route::post('/container/selection-technique/store', 'SelectionTechniqueController@store');
Route::post('/container/selection-technique/update', 'SelectionTechniqueController@update');
Route::delete('/container/selection-technique/delete/{id}', 'SelectionTechniqueController@delete');

//Container routes
Route::get('/container/get-all', 'ContainerController@getAll');
Route::get('/container/get/{id}', 'ContainerController@getContainer');
Route::post('/container/store', 'ContainerController@store');
Route::post('/container/update', 'ContainerController@update');
Route::delete('/container/delete/{id}', 'ContainerController@delete');

//Document Types routes
Route::get('/document-type/get-all', 'DocumentTypeController@getAll');
Route::get('/document-type/get/{id}', 'DocumentTypeController@getDocumentType');
Route::post('/document-type/store', 'DocumentTypeController@store');
Route::post('/document-type/update', 'DocumentTypeController@update');
Route::delete('/document-type/delete/{id}', 'DocumentTypeController@delete');

//Documents routes
Route::get('/document/get-all', 'DocumentController@getAll');
Route::get('/document/get-user-documents/{userId}', 'DocumentController@getUserDocuments');
Route::get('/document/get-user-sign-documents/{userId}', 'DocumentController@getUserSignDocuments');
Route::post('/document/get-by-ids', 'DocumentController@getDocumentsByIds');
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

//User CRUD routes
Route::get('/user/get-all', 'UserController@getAll');
Route::get('/user/get/{id}', 'UserController@getUser');
Route::post('/user/store', 'UserController@store');
Route::post('/user/update', 'UserController@update');
Route::delete('/user/delete/{id}', 'UserController@delete');
Route::post('/user/reset-password', 'UserController@resetPassword');

//Deletion Requests CRUD routes
Route::get('/deletion-request/get-all', 'DeletionRequestController@getAll');
Route::get('/deletion-request/get/{id}', 'DeletionRequestController@getDeletionRequest');
Route::post('/deletion-request/store', 'DeletionRequestController@store');
Route::delete('/deletion-request/delete/{id}', 'DeletionRequestController@delete');
Route::post('/deletion-request/accept', 'DeletionRequestController@acceptRequest');
Route::post('/deletion-request/reject', 'DeletionRequestController@rejectRequest');

//Spatie routes
Route::get('/spatie/role/get-all', 'UserController@getRoles');
