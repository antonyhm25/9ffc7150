<?php

namespace App\Http\Controllers;

use App\Models\CompanyIncomePayment;
use Illuminate\Http\Request;

class CompanyIncomePaymentsController extends Controller
{
    public function index()
    {
        $result = CompanyIncomePayment::with('companyIncome')->get();

        return response()->json($result);
    }
}
