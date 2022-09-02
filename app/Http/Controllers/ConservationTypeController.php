<?php

namespace App\Http\Controllers;

use App\Models\ConservationType;
use Illuminate\Http\Request;

class ConservationTypeController extends Controller
{
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
}
