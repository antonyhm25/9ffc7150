<?php

namespace App\Http\Controllers;

use App\Models\CompanyDebtPayment;
use Illuminate\Http\Request;

class CompanyDebtPaymentsController extends Controller
{
    public function index()
    {
        return CompanyDebtPayment::with('companyDebt')->get();
    }
}
