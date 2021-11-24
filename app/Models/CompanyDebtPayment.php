<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDebtPayment extends Model
{
    use HasFactory;

    public function companyDebt() 
    {
        return $this->belongsTo(CompanyDebt::class);
    }
}
