<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo_path',
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
        $brand = static::findById($id);
        if ($brand) {
            $brand->delete_flag = true;
            $brand->save();
        }
        return $brand;
    }

    public static function getMapFromIdToName()
    {
        $brands = static::listAll(['id', 'name']);
        $map = [];

        foreach ($brands as $brand) {
            $map[$brand->id] = $brand->name;
        }

        return $map;
    }

    public static function getMapFromSlugToId()
    {
        $brands = static::listAll(['id', 'slug']);
        $map = [];

        foreach ($brands as $brand) {
            $map[$brand->slug] = $brand->id;
        }

        return $map;
    }

    public static function listAll($columns = ['*'], $withDeletedBrands = false)
    {
        if ($withDeletedBrands) {
            return static::all($columns);
        }

        return static::where('delete_flag', false)->get($columns);
    }
}
