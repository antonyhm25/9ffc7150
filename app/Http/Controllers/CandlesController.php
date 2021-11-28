<?php

namespace App\Http\Controllers;

use App\Models\OtherProduct;
use App\Models\OtherProductOrder;
use Illuminate\Http\Request;

class CandlesController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'branchId' => 'required|exists:branches,id'
        ]);

        $response = OtherProductOrder::with('details.product')
            ->where('branch_id', $request->branchId)->get();

        return response()->json($response);
    }
}
