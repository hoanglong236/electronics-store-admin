<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'city',
        'district',
        'ward',
        'specific_address',
        'address_type',
        'default_flag',
    ];

    public static function retrieveByCustomerId($customerId)
    {
        return static::where('customer_id', $customerId)->get();
    }
}
