<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\BranchSafeBoxesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CompanyDebtsController;
use App\Http\Controllers\BusinessUnitsController;
use App\Http\Controllers\CompanyIncomesController;
use App\Http\Controllers\CompanyCustomersController;
use App\Http\Controllers\CompanyDebtPaymentsController;
use App\Http\Controllers\CompanyIncomePaymentsController;
use App\Http\Controllers\PaymentsController;

Route::middleware(['cors'])->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/login', [UserController::class, 'index']);

        Route::post('/logout', [UserController::class, 'logout']);

        Route::get('/branches', [BranchesController::class, 'index']);

        Route::get('/sales-lines', [SalesController::class, 'salesLine']);
        Route::get('/sales-specials', [SalesController::class, 'salesSpecial']);

        Route::get('/company-incomes', [CompanyIncomesController::class, 'index']);
        Route::post('/company-incomes', [CompanyIncomesController::class, 'store']);

        Route::get('/company-income-payments', [CompanyIncomePaymentsController::class, 'index']);

        Route::get('/company-debts', [CompanyDebtsController::class, 'index']);
        Route::post('/company-debts', [CompanyDebtsController::class, 'store']);
        Route::put('/company-debts/{companyDebt}/approved-rejected', [CompanyDebtsController::class, 'approved']);

        Route::get('/company-debt-payments', [CompanyDebtPaymentsController::class, 'index']);

        Route::get('/business-units', [BusinessUnitsController::class, 'index']);

        Route::get('/company-customers', [CompanyCustomersController::class, 'index']);

        Route::get('/suppliers', [SuppliersController::class, 'index']);

        Route::get('/inventories', [InventoryController::class, 'index']);

        Route::get('branch-safe-boxes', [BranchSafeBoxesController::class, 'index']);
        Route::post('branch-safe-boxes/{branchSafeBox}/cash-withdrawal', [BranchSafeBoxesController::class, 'cashWithdrawal']);

        Route::get('payments', [PaymentsController::class, 'index']);
    });

    Route::post('/login', [UserController::class, 'login']);
});
