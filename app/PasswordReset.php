<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class PasswordReset extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'email', 'token','created_at',
    ];
}
