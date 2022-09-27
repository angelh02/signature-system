<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackgroundController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $background = Background::where('id',$id)->first();
            if(!$background)
                return response()->json(['message' => 'BACKGROUND_DOES_NOT_EXIST'], 422);
            $background->delete();
            DB::commit();
            return response()->json($background, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $backgrounds = Background::all();

        return response()->json($backgrounds, 200);
    }

    public function getBackground($id)
    {
       $background = Background::where("id", $id)->first();

       return response()->json($background, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:4|max:10|unique:backgrounds,code',
            'name' => 'required|min:10|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $background = new Background();
            $background->code = $request->input('code');
            $background->name = $request->input('name');
            $background->save();
            DB::commit();
            return response()->json($background, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:backgrounds,id',
            'code' => 'required|min:4|max:10|unique:backgrounds,code,'.$request->input('id'),
            'name' => 'required|min:10|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $background = Background::where('id',$request->input('id'))->first();
            $background->code = $request->input('code');
            $background->name = $request->input('name');
            $background->save();
            DB::commit();
            return response()->json($background, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
