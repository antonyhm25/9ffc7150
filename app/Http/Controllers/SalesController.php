<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function salesLine(Request $request)
    {
        $request->validate([
            'branchId' => 'required|integer|exists:branches,id',
            'startDate' => 'required|date',
            'endDate' => 'required|date'
        ]);

        $amount = $this->salesLineQuery($request)
            ->select('total')
            ->sum('total');

        $sales = $this->salesLineQuery($request)
            ->select('sale_date','payment_method','branch_id','total')
            ->get();

        return response()->json([
            'amount'=> $amount,
            'sales' => $sales
        ], 200);
    }

    public function salesSpecial(Request $request)
    {
        $request->validate([
            'branchId' => 'required|integer|exists:branches,id',
            'skip' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'required|date'
        ]);

        $sales = $this->salesSpecialQuery($request)
            ->select(
                'sales.sale_date',
                'sales.payment_method',
                'sales.branch_id',
                'special_product_order_payments.amount',
                'special_product_orders.cake_type',
                'sales.total'
            )
            ->skip($request->skip)
            ->take(15)
            ->get();


        return response()->json([
            'amount'=>  $sales->sum('total'),
            'sales' => $sales
        ], 200);
    }

    private function salesLineQuery(Request $request) {
        return Sale::where('branch_id', $request->branchId)
        ->where('status', 1)
        ->where('invisible', 0)
        ->WhereBetween('sale_date',[$request->startDate, $request->endDate]);
    }

    private function salesSpecialQuery(Request $request) {
        return Sale::join('special_product_orders', 'sales.branch_id', '=', 'special_product_orders.branch_id')
        ->join('special_product_order_payments', 'special_product_orders.id', '=', 'special_product_order_payments.special_product_order_id')
        ->where('sales.branch_id', $request->branchId)
        ->where('sales.status', 1)
        ->where('sales.invisible', 0)
        ->WhereBetween('sale_date',[$request->startDate, $request->endDate]);
    }
}
