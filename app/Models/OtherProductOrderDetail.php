<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherProductOrderDetail extends Model
{
    use HasFactory;

    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(OtherProduct::class, 'other_product_id', 'id');
    }
}
