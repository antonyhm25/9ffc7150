<?php

namespace App\Http\Controllers;

use App\Models\CompanyDebt;
use Illuminate\Http\Request;

class CompanyDebtsController extends Controller
{
    public function index()
    {
        $result = CompanyDebt::all();

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
}
