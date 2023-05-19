<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements ICategoryRepository
{
    public function findById(int $id)
    {
        return Category::find($id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findBySlug(string $slug)
    {
        return Category::where([
            'slug' => $slug,
            'delete_flag' => false
        ])
            ->first();
    }

    public function create(array $attributes)
    {
        Category::create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        Category::find($id)
            ->where('delete_flag', false)
            ->update($attributes);
    }

    public function deleteById(int $id)
    {
        $category = $this->findById($id);
        if ($category) {
            $category->update(['delete_flag' => true]);
            return $category;
        }
        return false;
    }

    public function paginate(int $itemPerPage)
    {
        return Category::where('delete_flag', false)
            ->latest()
            ->paginate($itemPerPage);
    }

    public function searchAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        return DB::table('categories')
            ->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->select('categories.*')
            ->where('categories.delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('parent.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('parent.slug', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }

    public function listAll(array $columns = ['*'], bool $withDeletedBrands = false)
    {
        if ($withDeletedBrands) {
            return Category::all($columns);
        }

        return Category::where('delete_flag', false)->get($columns);
    }
}
