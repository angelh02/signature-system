<?php

namespace App\Http\Controllers;

use App\Models\ConservationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConservationTypeController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $conservationType = ConservationType::where('id',$id)->first();
            if(!$conservationType)
                return response()->json(['message' => 'CONSERVATION_TYPE_DOES_NOT_EXIST'], 422);
            $conservationType->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $conservationTypes = ConservationType::all();

        return response()->json($conservationTypes, 200);
    }

    public function getConservationType($id)
    {
        $conservationType = ConservationType::where("id", $id)->first();

        return response()->json($conservationType, 200);
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
            $conservationType = new ConservationType();
            $conservationType->code = $request->input('code');
            $conservationType->name = $request->input('name');
            $conservationType->save();
            DB::commit();
            return response()->json($conservationType, 200);
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
            $conservationType = ConservationType::where('id',$request->input('id'))->first();
            $conservationType->code = $request->input('code');
            $conservationType->name = $request->input('name');
            $conservationType->save();
            DB::commit();
            return response()->json($conservationType, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
