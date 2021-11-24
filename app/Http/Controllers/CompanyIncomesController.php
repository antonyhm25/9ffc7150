<?php

namespace App\Http\Controllers;

use App\Models\CompanyIncome;
use Illuminate\Http\Request;

class CompanyIncomesController extends Controller
{
    public function index()
    {
        $data = CompanyIncome::all();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_unit_id' => 'required|exists:business_units,id',
            'company_customer_id' => 'required|exists:company_customers,id',
            'subject' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'payed_amount' => 'required|numeric'
        ]);

        $companyIncome = CompanyIncome::create($request->only(
            'business_unit_id',
            'company_customer_id',
            'subject',
            'description',
            'amount',
            'payed_amount'
        ));

        return response()->json($companyIncome);
    }
}
