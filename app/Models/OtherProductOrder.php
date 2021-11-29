<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherProductOrder extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function details()
    {
        return $this->hasMany(OtherProductOrderDetail::class);
    }
}
