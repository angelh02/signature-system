<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;

class BackgroundController extends Controller
{
    public function getAll()
    {
        $backgrounds = Background::all();

        return response()->json($backgrounds, 200);
    }

    public function getBackground($id)
    {
       $background = Background::where("id", $id)->first();

       return response()->json($background, 200);
    }
}
