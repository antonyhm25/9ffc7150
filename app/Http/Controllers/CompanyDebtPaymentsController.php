<?php

namespace App\Http\Controllers;

use App\Models\CompanyDebtPayment;
use Illuminate\Http\Request;

class CompanyDebtPaymentsController extends Controller
{
    public function index()
    {
        $result = CompanyDebtPayment::with('companyDebt')->get();

        return  response()->json($result);
    }
}
