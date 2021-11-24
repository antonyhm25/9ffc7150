<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
 
    protected $fillable = [
        'name',
        'username',
        'password',
    ];
    protected $hidden = [
        "status",
            "created",
            "modified",
            "deleted_at",
            "profile",
            "api_token",
            "password_laravel",
    ];
    protected $casts = [
        'username_verified_at' => 'datetime',
    ];
}
