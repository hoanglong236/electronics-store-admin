<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'price',
        'discount_percent',
        'quantity',
        'warranty_period',
        'description',
        'main_image_path',
        'delete_flag',
    ];

    public static function findById($id)
    {
        return static::find($id)
            ->where('delete_flag', false)
            ->first();
    }

    public static function deleteById($id)
    {
        $product = static::findById($id);
        if ($product) {
            $product->delete_flag = true;
            $product->save();
        }
        return $product;
    }
}
