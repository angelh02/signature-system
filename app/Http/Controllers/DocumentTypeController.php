<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocumentTypeController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $documentType = DocumentType::where('id',$id)->first();
            if(!$documentType)
                return response()->json(['message' => 'DOCUMENT_TYPE_DOES_NOT_EXIST'], 422);
            $documentType->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $documentTypes = DocumentType::orderBy("name")->get();

        return response()->json($documentTypes, 200);
    }

    public function getDocumentType($id)
    {
        $documentType = DocumentType::where("id", $id)->first();

        return response()->json($documentType, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:1|max:10|unique:document_types,code',
            'name' => 'required|min:5|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $documentType = new DocumentType();
            $documentType->code = $request->input('code');
            $documentType->name = $request->input('name');
            $documentType->save();
            DB::commit();
            return response()->json($documentType, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:document_types,id',
            'code' => 'required|min:1|max:10|unique:document_types,code,'.$request->input('id'),
            'name' => 'required|min:5|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $documentType = DocumentType::where('id',$request->input('id'))->first();
            $documentType->code = $request->input('code');
            $documentType->name = $request->input('name');
            $documentType->save();
            DB::commit();
            return response()->json($documentType, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
