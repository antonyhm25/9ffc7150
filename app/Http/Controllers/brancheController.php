<?php

namespace App\Http\Controllers;

use App\Models\branche;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class brancheController extends Controller
{
    public function ver(){
        $tiendas = branche::select('id','name','address','status','is_cedis')
        ->Where('status','=','1')->Where('is_cedis','=','1')->get();
        return response()->json([
            'res' => true,
            'tiendas' => $tiendas,
        ], 200);
    }

}
