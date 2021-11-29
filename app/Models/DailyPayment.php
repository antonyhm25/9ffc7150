<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPayment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
