<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class BranchesController extends Controller
{
    public function index(){
        $response = Branch::Where('status', 1)
            ->Where('is_cedis', 1)->get();
        
        return response()->json($response);
    }

}
