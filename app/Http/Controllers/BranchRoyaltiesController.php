<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchRoyalties\BranchRoyaltyResult;
use App\Models\BranchRoyalty;
use Illuminate\Http\Request;

class BranchRoyaltiesController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'branchId' => 'required|exists:branches,id'
        ]);

        $response = BranchRoyalty::where('branch_id', $request->branchId)->get();

        return response()->json(BranchRoyaltyResult::collection($response));
    }
}
