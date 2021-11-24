<?php

namespace App\Http\Controllers;

use App\Models\BusinessUnit;
use Illuminate\Http\Request;

class BusinessUnitsController extends Controller
{
    public function index()
    {
        $result = BusinessUnit::all();

        return response()->json($result);
    }
}
