<?php

namespace App\Http\Controllers;

use App\Models\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContainerController extends Controller
{
    public function delete($id){
        try {
            DB::beginTransaction();
            //Consulta la clasificación con el id recibido
            $container = Container::where("id", $id)->first();
            if($container == null)
                return response()->json(["message" => "CONTAINER_DOES_NOT_EXISTS"], 402);
            //Elimina el registro
            $container->delete();
            DB::commit();
            return response()->json(["message" => "CONTAINER_DELETED"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function getAll()
    {
        $containers = Container::with([
            "conservationTime",
            "conservationType",
            "documentValue",
            "informationType",
            "selectionTechnique"
        ])->get();

        return response()->json($containers, 200);
    }

    public function getContainer($id)
    {
        $container = Container::with([
            "conservationTime",
            "conservationType",
            "documentValue",
            "informationType",
            "selectionTechnique"
        ])->where("id", $id)->first();

        return response()->json($container, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:10|max:30|unique:containers,name',
            'document_value_id' => 'required|numeric|exists:document_values,id',
            'conservation_time_id' => 'required|numeric|exists:conservation_times,id',
            'selection_technique_id' => 'required|numeric|exists:selection_techniques,id',
            'conservation_type_id' => 'required|numeric|exists:conservation_types,id',
            'information_type_id' => 'required|numeric|exists:information_types,id',
            'effective_date' => 'required|date'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Validamos que no exista la clasificación
            $container = Container::where("name", $request->input("name"))->first();
            if($container != null)
                return response()->json(["message" => "CONTAINER_ALREADY_EXISTS"], 402);
            else
                $container = new Container();
            //Capturamos los datos de la nueva clasificación
            $container->name = $request->input("name");
            $container->document_value_id = $request->input("document_value_id");
            $container->conservation_time_id = $request->input("conservation_time_id");
            $container->selection_technique_id = $request->input("selection_technique_id");
            $container->conservation_type_id = $request->input("conservation_type_id");
            $container->information_type_id = $request->input("information_type_id");
            $container->effective_date = $request->input("effective_date");
            //Guardamos los cambios
            $container->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info de la clasificación creada
            $container->load([
                "conservationTime",
                "conservationType",
                "documentValue",
                "informationType",
                "selectionTechnique"
            ]);
            return response()->json($container, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:containers,id',
            'name' => 'required|min:10|max:30|unique:containers,name,'.$request->input("id"),
            'document_value_id' => 'required|numeric|exists:document_values,id',
            'conservation_time_id' => 'required|numeric|exists:conservation_times,id',
            'selection_technique_id' => 'required|numeric|exists:selection_techniques,id',
            'conservation_type_id' => 'required|numeric|exists:conservation_types,id',
            'information_type_id' => 'required|numeric|exists:information_types,id',
            'effective_date' => 'required|date'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        
        try {
            DB::beginTransaction();
            //Validamos que no exista la clasificación con el mismo nombre
            $container = Container::where([["id", "!=", $request->input("id")],["name", $request->input("name")]])->first();
            if($container != null)
                return response()->json(["message" => "CONTAINER_ALREADY_EXISTS"], 402);
            //Validamos que exista nuestra clasificación para editarla
            $container = Container::where("id", $request->input("id"))->first();
            if($container == null)
                return response()->json(["message" => "CONTAINER_DOES_NOT_EXISTS"], 402);
            //Capturamos los datos de la nueva clasificación
            $container->name = $request->input("name");
            $container->document_value_id = $request->input("document_value_id");
            $container->conservation_time_id = $request->input("conservation_time_id");
            $container->selection_technique_id = $request->input("selection_technique_id");
            $container->conservation_type_id = $request->input("conservation_type_id");
            $container->information_type_id = $request->input("information_type_id");
            $container->effective_date = $request->input("effective_date");
            //Guardamos los cambios
            $container->save();
            DB::commit();

            //Cargamos las relaciones para retornar la info de la clasificación creada
            $container->load([
                "conservationTime",
                "conservationType",
                "documentValue",
                "informationType",
                "selectionTechnique"
            ]);
            return response()->json($container, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["line" => $e->getLine(),"message" => $e->getMessage()], 500);
        }
    }
}
