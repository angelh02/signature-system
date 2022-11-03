<?php

namespace App\Http\Controllers;

use App\Models\DeletionRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Whoops\Run;

class DeletionRequestController extends Controller
{
    public function acceptRequest(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:deletion_request,id',
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Change the deletion request status
            $deletionRequest = DeletionRequest::where('id',$request->input('id'))->where('status', 'Pendiente')->first();
            if(!$deletionRequest)
                return response()->json(['message' => 'DELETION_REQUEST_DOES_NOT_EXIST'], 422);
            $deletionRequest->status = "Aceptado";
            $deletionRequest->save();

            //Update document info to cancel document
            $document = Document::where('id', $deletionRequest->document_id)->first();
            if(!$document)
                return response()->json(['message' => 'DOCUMENT_DOES_NOT_EXIST'], 422);
            $document->canceled = true;
            $document->canceled_at = date('Y-m-d');
            $document->save();
            DB::commit();
            return response()->json($deletionRequest, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            DB::beginTransaction();
            $deletionRequest = DeletionRequest::where('id',$id)->first();
            if(!$deletionRequest)
                return response()->json(['message' => 'DELETION_REQUEST_DOES_NOT_EXIST'], 422);
            $deletionRequest->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll(){
        $deletionRequests = DeletionRequest::with('document.user', 'document.classification', 'document.container', 'document.documentType')->get();

        return response()->json($deletionRequests, 200);
    }

    public function getDeletionRequest($id){
        $deletionRequest = DeletionRequest::where('id', $id)->with('document.user', 'document.classification', 'document.container', 'document.documentType' )->first();

        return response()->json($deletionRequest, 200);
    }

    public function rejectRequest(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:deletion_request,id',
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Change the deletion request status
            $deletionRequest = DeletionRequest::where('id',$request->input('id'))->first();
            if(!$deletionRequest)
                return response()->json(['message' => 'DELETION_REQUEST_DOES_NOT_EXIST'], 422);
            $deletionRequest->status = "Rechazado";
            $deletionRequest->save();
            DB::commit();
            return response()->json($deletionRequest, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'document_id' => 'required|numeric|exists:documents,id',
            'subject' => 'required|min:10|max:255',
            'description' => 'required|min:10'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $deletionRequest = new DeletionRequest();
            $deletionRequest->subject = $request->input('subject');
            $deletionRequest->description = $request->input('description');
            $deletionRequest->document_id = $request->input('document_id');
            $deletionRequest->date = date('Y-m-d');
            $deletionRequest->save();
            DB::commit();
            return response()->json($deletionRequest, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
