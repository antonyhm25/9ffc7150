<?php

namespace App\Http\Controllers;

use App\Models\BranchUser;
use Illuminate\Http\Request;
use App\Models\BranchRoyalty;
use Illuminate\Validation\Rule;
use App\Models\BranchAnnualRoyalty;
use App\Models\BranchRoyaltyPayment;
use App\Models\BranchAnnualRoyaltyPayment;
use App\Http\Resources\BranchRoyalties\BranchRoyaltyResult;

class BranchRoyaltiesController extends Controller
{
    public function index(Request $request)
    {
        $response = null;

        $request->validate([
            'branchId' => 'required|exists:branches,id',
            'isAnual' => [
                'required',
                Rule::in([0, 1])
            ]
        ]);

        if ($request->boolean('isAnual')) {
            $response = BranchAnnualRoyalty::where('branch_id', $request->branchId)->get();
        } else {
            $response = BranchRoyalty::where('branch_id', $request->branchId)->get();
        }

        return response()->json(BranchRoyaltyResult::collection($response));
    }

    public function storeRoyaltyPayments(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'payment_date' => 'required|date',
            'payment_method' => 'required',
            'total' => 'required|numeric',
            'user_id' => 'required|integer',
            'nip' => 'required|integer|exists:branch_users,nip',
        ]);

        $branchUser = BranchUser::where('nip', $request->nip)
                ->where('branch_id', $request->branch_id)
                ->first();

        if (!$branchUser) {
            return response('invalid nip', 422);
        }

        $payment = BranchRoyaltyPayment::create([
            'payment_date' => $request->payment_date,
            'amount' => $request->total,
            'payment_method' => $request->payment_method,
            'branch_user_id' => $branchUser->id,
            'user_id' => $request->user_id,
            'branch_id' => $request->branch_id,
            'created' => now(),
            'modified' => now()
        ]);

        return response()->json($payment);
    }

    public function storeRoyaltyAnnualPayments(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'payment_date' => 'required|date',
            'payment_method' => 'required',
            'total' => 'required|numeric',
            'user_id' => 'required|integer',
            'nip' => 'required|integer|exists:branch_users,nip',
        ]);

        $branchUser = BranchUser::where('nip', $request->nip)
                ->where('branch_id', $request->branch_id)
                ->first();

        if (!$branchUser) {
            return response('invalid nip', 422);
        }

        $payment = BranchAnnualRoyaltyPayment::create([
            'payment_date' => $request->payment_date,
            'amount' => $request->total,
            'payment_method' => $request->payment_method,
            'branch_user_id' => $branchUser->id,
            'user_id' => $request->user_id,
            'branch_id' => $request->branch_id,
            'created' => now(),
            'modified' => now()
        ]);

        return response()->json($payment);
    }
}
