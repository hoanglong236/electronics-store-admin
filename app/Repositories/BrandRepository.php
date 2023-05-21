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

    public function paginate(int $itemPerPage)
    {
        return Brand::where('delete_flag', false)
            ->latest()
            ->paginate($itemPerPage);
    }

    public function searchAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        return Brand::where('delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }

    public function listAll(array $columns = ['*'], bool $withDeleted = false)
    {
        if ($withDeleted) {
            return Brand::all($columns);
        }

        return Brand::where('delete_flag', false)->get($columns);
    }
}
