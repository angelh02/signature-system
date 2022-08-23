<?php

namespace App\Http\Controllers;

use App\Models\ProductionArea;
use Illuminate\Http\Request;

class ProductionAreaController extends Controller
{
    public function getAll()
    {
        $productionAreas = ProductionArea::all();

        return response()->json($productionAreas, 200);
    }

    public function getProductionArea($id)
    {
        $productionArea = ProductionArea::where("id", $id)->first();

        return response()->json($productionArea, 200);
    }
}
