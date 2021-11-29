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

    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'payment_date' => 'required|date',
            'payment_method' => 'required',
            'total' => 'required|numeric',
            'user_id' => 'required|integer',
            'nip' => 'required|integer|exists:branch_users,nip',
        ]);

        try {

            $branchUser = BranchUser::where('nip', $request->nip)
                ->where('branch_id', $request->branch_id)
                ->first();

            if (!$branchUser) {
                return response('invalid nip', 422);
            }

            DB::beginTransaction();

            $dialyPayment = OtherProductDailyPayment::create([
                'payment_date' => $request->payment_date,
                'created' => now(),
                'modified' => now(),
            ]);

            $payment = $dialyPayment->payment()->create([
                'branch_id' => $request->branch_id,
                'total' => $request->total,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'payment_amount' => 0,
                'branch_user_id' => $branchUser->id,
                'user_id' => $request->user_id,
                'created' => now(),
                'modified' => now()
            ]);

            DB::commit();

            return response()->json($payment);

        } catch (Exception $ex) {
            DB::rollback();

            Log::debug($ex);

            return response('iternal error.', 500);
        }
    }
}
