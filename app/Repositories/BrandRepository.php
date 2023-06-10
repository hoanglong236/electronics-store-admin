<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository implements IBrandRepository
{
    public function findById(int $id)
    {
        return Brand::where(['id' => $id, 'delete_flag' => false])
            ->first();
    }

    public function create(array $attributes)
    {
        return Brand::create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $brand = $this->findById($id);
        if ($brand) {
            $brand->update($attributes);
            return $brand;
        }
        return false;
    }

    public function deleteById(int $id)
    {
        $brand = $this->findById($id);
        if ($brand) {
            $brand->update(['delete_flag' => true]);
            return $brand;
        }
        return false;
    }

    public function searchAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        $queryBuilder = Brand::query();

        if (strlen($escapedKeyword) > 0) {
            $queryBuilder->where(function ($query) use ($escapedKeyword) {
                $query->where('name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $escapedKeyword . '%');
            });
        }

        return $queryBuilder->where('delete_flag', false)
            ->latest('id')
            ->paginate($itemPerPage);
    }

    public function listAll(array $columns = ['*'], bool $withDeleted = false)
    {
        $queryBuilder = Brand::select($columns);

        if (!$withDeleted) {
            $queryBuilder->where('delete_flag', false);
        }

        return $queryBuilder->get();
    }
}
