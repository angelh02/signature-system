<?php

namespace App\Http\Controllers;

use App\Models\InformationType;
use Illuminate\Http\Request;

class InformationTypeController extends Controller
{
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
}
