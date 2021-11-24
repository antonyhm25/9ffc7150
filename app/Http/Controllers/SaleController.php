<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function venta(Request $request){
        
        $rules = array(
            'branch_id' => 'required',
            'fechaI'=>'required',
            'fechaF'=>'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $suma = sale::Select('sale_date','payment_method','branch_id','total')
        ->where('branch_id','=',$request->branch_id)
        ->where('status','=','1')->where('invisible','=','0')
        ->WhereBetween('sale_date',[$request->fechaI,$request->fechaF])
        ->get()->sum('total');
        $user = sale::Select('sale_date','payment_method','branch_id','total')
        ->where('branch_id','=',$request->branch_id)
        ->where('status','=','1')->where('invisible','=','0')
        ->WhereBetween('sale_date',[$request->fechaI,$request->fechaF])
        ->get();
        return response()->json([
            'res' => true,
            'suma'=>$suma,
            'tiendas' => $user
        ], 200);
    }
}
