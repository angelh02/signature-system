<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function getAll()
    {
        $documentTypes = DocumentType::all();

        return response()->json($documentTypes, 200);
    }

    public function getDocumentType($id)
    {
        $documentType = DocumentType::where("id", $id)->first();

        return response()->json($documentType, 200);
    }
}
