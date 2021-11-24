<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDebt extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilterByApproved(Builder $query, $approved) 
    {
        if (is_null($approved)) {
            return $query;
        }

        if ($approved) {
            return $query->whereNotNull('approved_by');
        }

        return $query->whereNull('approved_by');
    }
}
