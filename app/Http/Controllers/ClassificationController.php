<?php

namespace App\Http\Controllers;

use App\Models\Background;
use App\Models\Classification;
use App\Models\ProductionArea;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassificationController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            //Consulta la clasificación con el id recibido
            $classification = Classification::where("id", $id)->first();
            if($classification == null)
                return response()->json(["message" => "CLASSIFICATION_DOES_NOT_EXISTS"], 402);
            //Elimina el registro
            $classification->delete();
            DB::commit();
            return response()->json(["message" => "CLASSIFICATION_DELETED"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
        
    }

    public function getAll()
    {
        $classifications = Classification::with([
            "background", 
            "section", 
            "productionArea"
        ])->orderBy("name")->get();

        return response()->json($classifications);
    }

    public function getClassification($id)
    {
        $classification = Classification::with([
            "background", 
            "section", 
            "productionArea"
        ])->where("id", $id)->first();

        return response()->json($classification);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'background_id' => 'required|numeric|exists:backgrounds,id',
            'section_id' => 'required|numeric|exists:sections,id',
            'series' => 'required|max:10',
            'subseries' => 'nullable|max:10',
            'production_area_id' => 'required|numeric|exists:production_areas,id',
            'start_period' => 'required|numeric',
            'end_period' => 'nullable|numeric',
            'consecutive_number' => 'required|numeric'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            //Obtenemos los datos para poder crear un nombre a partir de los codigos de fondo, seccion y area de produccion
            $subseries = $request->input("subseries") != null ? ".".$request->input("subseries") : "";
            $endPeriod = $request->input("end_period") != null ? "-".$request->input("end_period") : "";
            $backgroundCode = (Background::where("id", $request->input("background_id"))->first())->code;
            $sectionCode = (Section::where("id", $request->input("section_id"))->first())->code;
            $productionAreaCode = (ProductionArea::where("id", $request->input("production_area_id"))->first())->code;
            //Asignamos el nombre en base a los datos del request
            $name = $backgroundCode.":".$sectionCode.".".$request->input("series").$subseries."/".$productionAreaCode.$request->input("start_period").$endPeriod."/".$request->input("consecutive_number");
            DB::beginTransaction();
            //Validamos que no exista la clasificación
            $classification = Classification::where("name", $name)->first();
            if($classification != null)
                return response()->json(["message" => "CLASSIFICATION_ALREADY_EXISTS"], 402);
            else
                $classification = new Classification();
            //Capturamos los datos de la nueva clasificación
            $classification->name = $name;
            $classification->background_id = $request->input("background_id");
            $classification->section_id = $request->input("section_id");
            $classification->series = $request->input("series");
            $classification->subseries = $request->input("subseries");
            $classification->production_area_id = $request->input("production_area_id");
            $classification->start_period = $request->input("start_period");
            $classification->end_period = $request->input("end_period");
            $classification->consecutive_number = $request->input("consecutive_number");
            //Guardamos los cambios
            $classification->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info de la clasificación creada
            $classification->load([
                "background",
                "section",
                "productionArea"
            ]);
            return response()->json($classification, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:classifications,id',
            'background_id' => 'required|numeric|exists:backgrounds,id',
            'section_id' => 'required|numeric|exists:sections,id',
            'series' => 'required|max:10',
            'subseries' => 'nullable|max:10',
            'production_area_id' => 'required|numeric|exists:production_areas,id',
            'start_period' => 'required|numeric',
            'end_period' => 'nullable|numeric',
            'consecutive_number' => 'required|numeric'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            //Obtenemos los datos para poder crear un nombre a partir de los codigos de fondo, seccion y area de produccion
            $subseries = $request->input("subseries") != null ? ".".$request->input("subseries") : "";
            $endPeriod = $request->input("end_period") != null ? "-".$request->input("end_period") : "";
            $backgroundCode = (Background::where("id", $request->input("background_id"))->first())->code;
            $sectionCode = (Section::where("id", $request->input("section_id"))->first())->code;
            $productionAreaCode = (ProductionArea::where("id", $request->input("production_area_id"))->first())->code;
            //Asignamos el nombre en base a los datos del request
            $name = $backgroundCode.":".$sectionCode.".".$request->input("series").$subseries."/".$productionAreaCode.$request->input("start_period").$endPeriod."/".$request->input("consecutive_number");
            DB::beginTransaction();
            //Validamos que no exista la clasificación con el mismo nombre
            $classification = Classification::where([["id", "!=", $request->input("id")],["name", $name]])->first();
            if($classification != null)
                return response()->json(["message" => "CLASSIFICATION_ALREADY_EXISTS"], 402);
            //Validamos que exista nuestra clasificación para editarla
            $classification = Classification::where("id", $request->input("id"))->first();
            if($classification == null)
                return response()->json(["message" => "CLASSIFICATION_DOES_NOT_EXISTS"], 402);
            //Capturamos los datos de la nueva clasificación
            $classification->name = $name;
            $classification->background_id = $request->input("background_id");
            $classification->section_id = $request->input("section_id");
            $classification->series = $request->input("series");
            $classification->subseries = $request->input("subseries");
            $classification->production_area_id = $request->input("production_area_id");
            $classification->start_period = $request->input("start_period");
            $classification->end_period = $request->input("end_period");
            $classification->consecutive_number = $request->input("consecutive_number");
            //Guardamos los cambios
            $classification->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info de la clasificación creada
            $classification->load([
                "background",
                "section",
                "productionArea"
            ]);
            return response()->json($classification, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }
}
