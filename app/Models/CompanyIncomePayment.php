<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyIncomePayment extends Model
{
    use HasFactory;

    public function companyIncome() 
    {
        return $this->belongsTo(CompanyIncome::class);
    }
}
