<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'id' => 'integer',
        'branch_id' => 'integer',
        'daily_payment_id' => 'integer',
        'total' => 'double'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
