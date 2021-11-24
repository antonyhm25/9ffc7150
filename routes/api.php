<?php

use App\Http\Controllers\AccountsReceivableController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\brancheController;
use App\Http\Controllers\DebtsPayController;
use App\Http\Controllers\SaleController;




Route::group(['middleware' => 'auth:api'], function () {
    
    Route::get('/login', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']); 
    Route::get('/datos',[brancheController::class,'ver']);
    Route::post('/sales',[SaleController::class,'venta']);

    Route::get('/company-incomes', [AccountsReceivableController::class, 'index']);
    Route::get('/company-debts-pay', [DebtsPayController::class, 'index']);
});  

Route::post('/login', [UserController::class, 'login']);
