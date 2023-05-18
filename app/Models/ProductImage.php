<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
    ];

    public static function findById($id)
    {
        return static::find($id)->first();
    }

    public static function deleteById($id)
    {
        $productImage = static::find($id);
        if ($productImage) {
            $productImage->delete();
        }
        return $productImage;
    }

    public static function retrieveByProductId($productId)
    {
        return static::where('product_id', $productId)->get();
    }
}
