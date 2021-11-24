<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index() 
    {
        $result = Supplier::all();

        return response()->json($result);
    }
}
