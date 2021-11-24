<?php

namespace App\Http\Controllers;

use App\Models\CompanyDebt;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyDebtsController extends Controller
{
    public function index(Request $request)
    {
        $approved = $request->has('approved') ? $request->boolean('approved') : null;

        $result = CompanyDebt::filterByApproved($approved)->get();

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_unit_id' => 'required|exists:business_units,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'subject' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'payed_amount' => 'required|numeric'
        ]);

        $companyDebt = CompanyDebt::create($request->only(
            'business_unit_id',
            'supplier_id',
            'subject',
            'description',
            'amount',
            'payed_amount'
        ));

        return response()->json($companyDebt);
    }

    public function approved(Request $request, CompanyDebt $companyDebt) 
    {
        $request->validate([
            'approved_by' => 'nullable',
            'rejected' => [
                'required',
                Rule::in([0, 1])
            ]
        ]);

        $companyDebt->fill($request->only('approved_by', 'rejected'));
        $companyDebt->save();

        return response()->json($companyDebt);
    }
}
