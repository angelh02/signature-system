<?php

namespace App\Http\Controllers;

use App\Models\DocumentValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocumentValueController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $documentValue = DocumentValue::where('id',$id)->first();
            if(!$documentValue)
                return response()->json(['message' => 'DOCUMENT_VALUE_DOES_NOT_EXIST'], 422);
            $documentValue->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $documentValues = DocumentValue::all();

        return response()->json($documentValues, 200);
    }

    public function getDocumentValue($id)
    {
        $documentValue = DocumentValue::where("id", $id)->first();

        return response()->json($documentValue, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:4|max:10|unique:sections,code',
            'name' => 'required|min:10|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $documentValue = new DocumentValue();
            $documentValue->code = $request->input('code');
            $documentValue->name = $request->input('name');
            $documentValue->save();
            DB::commit();
            return response()->json($documentValue, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:sections,id',
            'code' => 'required|min:4|max:10|unique:sections,code,'.$request->input('id'),
            'name' => 'required|min:10|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $documentValue = DocumentValue::where('id',$request->input('id'))->first();
            $documentValue->code = $request->input('code');
            $documentValue->name = $request->input('name');
            $documentValue->save();
            DB::commit();
            return response()->json($documentValue, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
