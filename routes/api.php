<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\brancheController;
use App\Http\Controllers\CompanyDebtsController;
use App\Http\Controllers\CompanyIncomesController;
use App\Http\Controllers\CompanyDebtPaymentsController;
use App\Http\Controllers\CompanyIncomePaymentsController;

Route::group(['middleware' => 'auth:api'], function () {
    
    Route::get('/login', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']); 
    Route::get('/datos',[brancheController::class,'ver']);
    Route::post('/sales',[SaleController::class,'venta']);

    Route::get('/company-incomes', [CompanyIncomesController::class, 'index']);
    Route::post('/company-incomes', [CompanyIncomesController::class, 'store']);
    Route::get('/company-income-payments', [CompanyIncomePaymentsController::class, 'index']);
    Route::get('/company-debts', [CompanyDebtsController::class, 'index']);
    Route::get('/company-debt-payments', [CompanyDebtPaymentsController::class, 'index']);    
});

Route::post('/login', [UserController::class, 'login']);
