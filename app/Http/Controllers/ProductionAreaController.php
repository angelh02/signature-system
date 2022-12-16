<?php

namespace App\Http\Controllers;

use App\Models\ProductionArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductionAreaController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $productionArea = ProductionArea::where('id',$id)->first();
            if(!$productionArea)
                return response()->json(['message' => 'PRODUCTION_AREA_DOES_NOT_EXIST'], 422);
            $productionArea->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $productionAreas = ProductionArea::orderBy("name")->get();

        return response()->json($productionAreas, 200);
    }

    public function getProductionArea($id)
    {
        $productionArea = ProductionArea::where("id", $id)->first();

        return response()->json($productionArea, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:1|max:10|unique:production_areas,code',
            'name' => 'required|min:5|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $productionArea = new ProductionArea();
            $productionArea->code = $request->input('code');
            $productionArea->name = $request->input('name');
            $productionArea->save();
            DB::commit();
            return response()->json($productionArea, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:production_areas,id',
            'code' => 'required|min:1|max:10|unique:production_areas,code,'.$request->input('id'),
            'name' => 'required|min:5|max:255'
        ]);
        if($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            $productionArea = ProductionArea::where('id',$request->input('id'))->first();
            $productionArea->code = $request->input('code');
            $productionArea->name = $request->input('name');
            $productionArea->save();
            DB::commit();
            return response()->json($productionArea, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
