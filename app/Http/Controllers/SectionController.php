<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            $section = Section::where('id',$id)->first();
            if(!$section)
                return response()->json(['message' => 'SECTION_DOES_NOT_EXIST'], 422);
            $section->delete();
            DB::commit();
            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $sections = Section::all();

        return response()->json($sections, 200);
    }

    public function getSection($id)
    {
        $section = Section::where("id", $id)->first();

        return response()->json($section, 200);
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
            $section = new Section();
            $section->code = $request->input('code');
            $section->name = $request->input('name');
            $section->save();
            DB::commit();
            return response()->json($section, 200);
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
            $section = Section::where('id',$request->input('id'))->first();
            $section->code = $request->input('code');
            $section->name = $request->input('name');
            $section->save();
            DB::commit();
            return response()->json($section, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }
}
