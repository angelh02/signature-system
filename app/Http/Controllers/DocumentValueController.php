<?php

namespace App\Http\Controllers;

use App\Models\DocumentValue;
use Illuminate\Http\Request;

class DocumentValueController extends Controller
{
    public function getAll()
    {
        $documentalValues = DocumentValue::all();

        return response()->json($documentalValues, 200);
    }

    public function getDocumentalValue($id)
    {
        $documentalValue = DocumentValue::where("id", $id)->first();

        return response()->json($documentalValue, 200);
    }
}
