<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchRoyalties\BranchRoyaltyResult;
use App\Models\BranchAnnualRoyalty;
use App\Models\BranchRoyalty;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
}
