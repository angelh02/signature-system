<?php

namespace App\Http\Controllers;

use App\Models\ConservationTime;
use Illuminate\Http\Request;

class ConservationTimeController extends Controller
{
    public function getAll()
    {
        $conservationTimes = ConservationTime::all();

        return response()->json($conservationTimes, 200);
    }

    public function getConservationTime($id)
    {
        $conservationTime = ConservationTime::where("id", $id)->first();

        return response()->json($conservationTime, 200);
    }
}
