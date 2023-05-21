<?php

namespace App\Repositories;

use App\DataFilterConstants\ProductSearchOptionConstants;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductRepository implements IProductRepository
{
    public function findById(int $id)
    {
        return Product::where(['id' => $id, 'delete_flag' => false])
            ->first();
    }

    public function findBySlug(string $slug)
    {
        return Product::where(['slug' => $slug, 'delete_flag' => false])
            ->first();
    }

    public function getCustomProductById(int $id)
    {
        return $this->getCustomProductQueryBuilder()
            ->where('products.id', $id)
            ->first();
    }

    public function create(array $attributes)
    {
        return Product::create($attributes);
    }

    public function update(array $attributes, int $id)
    {
        $product = $this->findById($id);
        if ($product) {
            $product->update($attributes);
            return $product;
        }
        return false;
    }

    public function deleteById(int $id)
    {
        $product = $this->findById($id);
        if ($product) {
            $product->update(['delete_flag' => true]);
            return $product;
        }
        return false;
    }

    public function paginateCustomProducts(int $itemPerPage)
    {
        return $this->getCustomProductQueryBuilder()
            ->latest()
            ->paginate($itemPerPage);
    }

    public function searchCustomProductsAndPaginate(
        string $searchOption, string $escapedKeyword, int $itemPerPage
    ) {
        switch ($searchOption) {
            case ProductSearchOptionConstants::SEARCH_ALL:
                return $this->searchCustomProductsByAllAndPaginate($escapedKeyword, $itemPerPage);
            case ProductSearchOptionConstants::SEARCH_CATEGORY:
                return $this->searchCustomProductsByCategoryAndPaginate($escapedKeyword, $itemPerPage);
            case ProductSearchOptionConstants::SEARCH_BRAND:
                return $this->searchCustomProductsByBrandAndPaginate($escapedKeyword, $itemPerPage);
            default:
                return new LengthAwarePaginator([], 0, $itemPerPage);
        }
    }

    private function searchCustomProductsByAllAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        return $this->getCustomProductQueryBuilder()
            ->where(function ($query) use ($escapedKeyword) {
                $query->Where('products.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('products.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.slug', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }

    private function searchCustomProductsByCategoryAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        return $this->getCustomProductQueryBuilder()
            ->where(function ($query) use ($escapedKeyword) {
                $query->Where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }

    private function searchCustomProductsByBrandAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        return $this->getCustomProductQueryBuilder()
            ->where(function ($query) use ($escapedKeyword) {
                $query->Where('brands.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.slug', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }

    private function getCustomProductQueryBuilder()
    {
        return DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'brands.name as brand_name',
            )
            ->where('products.delete_flag', false);
    }

    public function listAll(array $columns = ['*'], bool $withDeleted = false)
    {
        if ($withDeleted) {
            return Product::all($columns);
        }

        return Product::where('delete_flag', false)->get($columns);
    }

    public function retrieveProductImagesByProductId(int $productId)
    {
        return ProductImage::where('product_id', $productId)->get();
    }

    public function createProductImage(array $attributes)
    {
        return ProductImage::create($attributes);
    }

    public function deleteProductImageById(int $id)
    {
        $productImage = ProductImage::find($id);
        if ($productImage) {
            $productImage->delete();
            return $productImage;
        }
        return false;
    }

    public function listAllProductImages(array $columns = ['*'])
    {
        return ProductImage::all($columns);
    }
}
