<?php

namespace App\Http\Controllers;

use App\Models\DocumentValue;
use Illuminate\Http\Request;

class DocumentValueController extends Controller
{
    public function getAll()
    {
        $documentValues = DocumentValue::all();

        return response()->json($documentValues, 200);
    }

    public function getDocumentValue($id)
    {
        $documentValue = DocumentValue::where("id", $id)->first();

        return response()->json($documentValue, 200);
    }
}
