<?php

namespace App\Http\Controllers;

use App\Models\SelectionTechnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SelectionTechniqueController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $selectionTechnique = SelectionTechnique::where('id',$id)->first();
            if(!$selectionTechnique)
                return response()->json(['message' => 'INFORMATION_TYPE_DOES_NOT_EXIST'], 422);
            $selectionTechnique->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $selectionTechniques = SelectionTechnique::all();

        return response()->json($selectionTechniques, 200);
    }

    public function getSelectionTechnique($id)
    {
        $selectionTechnique = SelectionTechnique::where("id", $id)->first();

        return response()->json($selectionTechnique, 200);
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
            $selectionTechnique = new SelectionTechnique();
            $selectionTechnique->code = $request->input('code');
            $selectionTechnique->name = $request->input('name');
            $selectionTechnique->save();
            DB::commit();
            return response()->json($selectionTechnique, 200);
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
            $selectionTechnique = SelectionTechnique::where('id',$request->input('id'))->first();
            $selectionTechnique->code = $request->input('code');
            $selectionTechnique->name = $request->input('name');
            $selectionTechnique->save();
            DB::commit();
            return response()->json($selectionTechnique, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
