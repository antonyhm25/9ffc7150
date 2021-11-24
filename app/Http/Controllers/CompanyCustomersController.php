<?php

namespace App\Http\Controllers;

use App\Models\CompanyCustomer;
use Illuminate\Http\Request;

class CompanyCustomersController extends Controller
{
    public function index()
    {
        $result = CompanyCustomer::all();

        return response()->json($result);
    }
}
