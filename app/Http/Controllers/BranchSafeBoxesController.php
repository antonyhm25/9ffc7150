<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\BranchSafeBox;
use App\Models\SaleboxWithdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchSafeBoxesController extends Controller
{
    public function index(Request $request) 
    {
        $request->validate([
            'branchId' => 'required|integer|exists:branches,id'
        ]);

        $response = BranchSafeBox::where('branch_id', $request->branchId)
            ->get();

        return response()->json($response);
    }

    public function cashWithdrawal(Request $request, BranchSafeBox $branchSafeBox)
    {
        $request->validate([
            'cash_amount' => 'required|numeric',
            'description' => 'required',
            'branchId' => 'required|integer|exists:branches,id'
        ]);

        if ($request->cash_amount > $branchSafeBox->cash_amount) {
            return response('efectivo insuficiente', 400);
        }

        try {
            DB::beginTransaction();

            $branchSafeBox->cash_amount = $branchSafeBox->cash_amount - $request->cash_amount;
            $branchSafeBox->save();

            $withdrawal = SaleboxWithdrawal::create([
                'branch_id' => $branchSafeBox->branch_id,
                'branch_user_id' => 0,
                'cash_amount' => $request->cash_amount,
                'debit_amount' => $branchSafeBox->debit_amount,
                'movement_date' => now(),
                'created' => now(),
                'modified' => now(),
                'description' => $request->description,
                'is_transfer' => 0,
                'is_deposit' => 0
            ]);

            DB::commit();

            return response()->json([
                'id' => $branchSafeBox->id,
                'name' => $branchSafeBox->name,
                'cash_amount' => $branchSafeBox->cash_amount,
                'cash_withdrawal' => $withdrawal->cash_amount,
                'description' => $withdrawal->description,
            ]);

        } catch(Exception $ex) {
            Log::debug($ex);

            DB::rollBack();

            return response($ex, 500);
        }
    }
}
