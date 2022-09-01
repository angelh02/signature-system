<?php

namespace App\Http\Controllers;

use App\Models\SelectionTechnique;
use Illuminate\Http\Request;

class SelectionTechniqueController extends Controller
{
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
}
