<?php

namespace App\Http\Controllers;

use App\Http\Resources\Payments\PaymentResult;
use App\Models\Payment;
use Illuminate\Http\Request;

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
}
