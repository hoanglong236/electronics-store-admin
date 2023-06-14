<?php

namespace App\Repositories\Concretes;

use App\Models\Category;
use App\Repositories\ICategoryRepository;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements ICategoryRepository
{
    public function findById(int $id)
    {
        return Category::where(['id' => $id, 'delete_flag' => false])
            ->first();
    }

    public function create(array $attributes)
    {
        return Category::create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $category = $this->findById($id);
        if ($category) {
            $category->update($attributes);
            return $category;
        }
        return false;
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

    public function searchAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        $queryBuilder = DB::table('categories');

        if (strlen($escapedKeyword) === 0) {
            $queryBuilder->select('categories.*');
        } else {
            $queryBuilder->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
                ->select('categories.*')
                ->where(function ($query) use ($escapedKeyword) {
                    $query->where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                        ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%')
                        ->orWhere('parent.name', 'LIKE', '%' . $escapedKeyword . '%')
                        ->orWhere('parent.slug', 'LIKE', '%' . $escapedKeyword . '%');
                });
        }

        return $queryBuilder
            ->where('categories.delete_flag', false)
            ->latest('categories.id')
            ->paginate($itemPerPage);
    }

    public function listAll(array $columns = ['*'], bool $withDeleted = false)
    {
        $queryBuilder = Category::select($columns);

        if (!$withDeleted) {
            $queryBuilder->where('delete_flag', false);
        }

        return $queryBuilder->get();
    }
}
