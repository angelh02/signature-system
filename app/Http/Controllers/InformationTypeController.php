<?php

namespace App\Http\Controllers;

use App\Models\InformationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InformationTypeController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $informationType = InformationType::where('id',$id)->first();
            if(!$informationType)
                return response()->json(['message' => 'INFORMATION_TYPE_DOES_NOT_EXIST'], 422);
            $informationType->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $informationTypes = InformationType::all();

        return response()->json($informationTypes, 200);
    }

    public function getInformationType($id)
    {
        $informationType = InformationType::where("id", $id)->first();

        return response()->json($informationType, 200);
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
            $informationType = new InformationType();
            $informationType->code = $request->input('code');
            $informationType->name = $request->input('name');
            $informationType->save();
            DB::commit();
            return response()->json($informationType, 200);
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
            $informationType = InformationType::where('id',$request->input('id'))->first();
            $informationType->code = $request->input('code');
            $informationType->name = $request->input('name');
            $informationType->save();
            DB::commit();
            return response()->json($informationType, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
