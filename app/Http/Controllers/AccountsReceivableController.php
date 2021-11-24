<?php

namespace App\Http\Controllers;

use App\Models\CompanyIncome;
use Illuminate\Http\Request;

class AccountsReceivableController extends Controller
{
    public function index()
    {
        return CompanyIncome::all();
    }
}
