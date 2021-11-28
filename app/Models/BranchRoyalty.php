<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchRoyalty extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'branch_id' => 'integer',
        'amount' => 'double'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
