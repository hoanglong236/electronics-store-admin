<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'icon_path',
        'delete_flag',
    ];

    public static function findById($id)
    {
        return static::find($id)
            ->where('delete_flag', false)
            ->first();
    }

    public static function findBySlug($slug)
    {
        return static::where(['slug' => $slug, 'delete_flag' => false])
            ->first();
    }

    public static function deleteById($id)
    {
        $category = static::findById($id);
        if ($category) {
            $category->delete_flag = true;
            $category->save();
        }
        return $category;
    }

    public static function getMapFromIdToName()
    {
        $categories = static::listAll(['id', 'name']);
        $map = [];

        foreach ($categories as $category) {
            $map[$category->id] = $category->name;
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
