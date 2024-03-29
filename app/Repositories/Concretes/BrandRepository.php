<?php

namespace App\Repositories\Concretes;

use App\Models\Brand;
use App\Repositories\IBrandRepository;

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
        return $this->update(['delete_flag' => true], $id);
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
