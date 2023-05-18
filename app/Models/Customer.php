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

    public static function findById($id)
    {
        return static::find($id)
            ->where('delete_flag', false)
            ->first();
    }

    public static function deleteById($id)
    {
        $customer = static::findById($id);
        if ($customer) {
            $customer->delete_flag = true;
            $customer->save();
        }
        return $customer;
    }
}
