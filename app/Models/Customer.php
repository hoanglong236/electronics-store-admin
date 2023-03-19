<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'phone',
        'email',
        'password',
        'disable_flag',
        'delete_flag',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];
}
