<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Payments\PaymentResult;
use App\Models\BranchUser;
use App\Models\DailyPayment;
use Illuminate\Support\Facades\Log;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'branchId' => 'required|exists:branches,id'
        ]);

        $response = Payment::where('branch_id', $request->branchId)->get();

        return response()->json(PaymentResult::collection($response));
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

            $dialyPayment = DailyPayment::create([
                'payment_date' => $request->payment_date,
                'created' => now(),
                'modified' => now(),
                'user_id' => $request->user_id
            ]);

             $payment = $dialyPayment->payment()->create([
                'branch_id' => $request->branch_id,
                'total' => $request->total,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'branch_user_id' => $branchUser->id,
                'user_id' => $request->user_id,
                'orders_amount' => 0,
                'special_orders_amount' => 0,
                'balance' => 0,
                'payment_amount' => 0,
                'additional_payment_amount' => 0,
                'additional_payment_method' => '',
                'additional_payment_date' => now(),
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
