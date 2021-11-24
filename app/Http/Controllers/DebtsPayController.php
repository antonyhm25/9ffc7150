<?php

namespace App\Http\Controllers;

use App\Models\CompanyDebt;
use Illuminate\Http\Request;

class DebtsPayController extends Controller
{
    public function index()
    {
        return CompanyDebt::all();
    }
}
