<?php

namespace App\Http\Controllers;

use App\Models\ConservationTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConservationTimeController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $conservationTime = ConservationTime::where('id',$id)->first();
            if(!$conservationTime)
                return response()->json(['message' => 'CONSERVATION_TIME_DOES_NOT_EXIST'], 422);
            $conservationTime->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $conservationTimes = ConservationTime::all();

        return response()->json($conservationTimes, 200);
    }

    public function getConservationTime($id)
    {
        $conservationTime = ConservationTime::where("id", $id)->first();

        return response()->json($conservationTime, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:1|max:10|unique:sections,code',
            'name' => 'required|min:5|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $conservationTime = new ConservationTime();
            $conservationTime->code = $request->input('code');
            $conservationTime->name = $request->input('name');
            $conservationTime->save();
            DB::commit();
            return response()->json($conservationTime, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:sections,id',
            'code' => 'required|min:1|max:10|unique:sections,code,'.$request->input('id'),
            'name' => 'required|min:5|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $conservationTime = ConservationTime::where('id',$request->input('id'))->first();
            $conservationTime->code = $request->input('code');
            $conservationTime->name = $request->input('name');
            $conservationTime->save();
            DB::commit();
            return response()->json($conservationTime, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
