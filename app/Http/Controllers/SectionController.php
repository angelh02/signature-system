<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
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
}
