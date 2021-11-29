<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\BranchUser;
use App\Models\OtherProduct;
use Illuminate\Http\Request;
use App\Models\OtherProductOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\OtherProductDailyPayment;

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

    public function update(Request $request, OtherProductOrder $otherProductOrder)
    {
        $request->validate([
            'total' => 'required|numeric',
        ]);

        try {

            if ($request->total < $otherProductOrder->total) {
                return response('invalid data', 422);
            }

           $otherProductOrder->total = $otherProductOrder->total - $request->total;
           $otherProductOrder->save();

            return response()->json($otherProductOrder);

        } catch (Exception $ex) {
            DB::rollback();

            Log::debug($ex);

            return response('iternal error.', 500);
        }
    }
}
