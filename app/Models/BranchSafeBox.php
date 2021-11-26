<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchSafeBox extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'double',
        'cash_amount' => 'double',
        'debit_amount' => 'double',
        'credit_amount' => 'double',
    ];
}
