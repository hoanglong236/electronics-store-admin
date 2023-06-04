<?php

namespace App\Repositories;

use App\DataFilterConstants\ProductSearchOptionConstants;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class ProductRepository implements IProductRepository
{
    public function findById(int $id)
    {
        return Product::where(['id' => $id, 'delete_flag' => false])
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

    private function getSearchProductsByAllQueryBuilder(string $escapedKeyword)
    {
        return DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where(function ($query) use ($escapedKeyword) {
                $query->Where('products.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('products.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.slug', 'LIKE', '%' . $escapedKeyword . '%');
            });
    }

    private function getSearchProductsByCategoryQueryBuilder(string $escapedKeyword)
    {
        return DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where(function ($query) use ($escapedKeyword) {
                $query->Where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%');
            });
    }

    private function getSearchProductsByBrandQueryBuilder(string $escapedKeyword)
    {
        return DB::table('products')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where(function ($query) use ($escapedKeyword) {
                $query->Where('brands.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.slug', 'LIKE', '%' . $escapedKeyword . '%');
            });
    }

    private function getSearchProductsQueryBuilder(
        string $searchOption = null,
        string $escapedKeyword = null
    ) {
        $queryBuilder = null;
        if (!is_null($escapedKeyword) && strlen($escapedKeyword) > 0) {
            switch ($searchOption) {
                case ProductSearchOptionConstants::SEARCH_ALL:
                    $queryBuilder = $this->getSearchProductsByAllQueryBuilder($escapedKeyword);
                    break;
                case ProductSearchOptionConstants::SEARCH_CATEGORY:
                    $queryBuilder = $this->getSearchProductsByCategoryQueryBuilder($escapedKeyword);
                    break;
                case ProductSearchOptionConstants::SEARCH_BRAND:
                    $queryBuilder = $this->getSearchProductsByBrandQueryBuilder($escapedKeyword);
                    break;
            }
        }
        $queryBuilder = $queryBuilder ?? DB::table('products');
        return $queryBuilder->select(
            'products.id',
            'products.name',
            'products.price',
            'products.discount_percent',
            'products.quantity',
            'products.main_image_path'
        );
    }

    public function paginateCustomProducts(int $itemPerPage)
    {
        return $this->getSearchProductsQueryBuilder()
            ->latest('id')
            ->paginate($itemPerPage);
    }

    public function searchCustomProductsAndPaginate(
        string $searchOption, string $escapedKeyword, int $itemPerPage
    ) {
        return $this->getSearchProductsQueryBuilder($searchOption, $escapedKeyword)
            ->latest('id')
            ->paginate($itemPerPage);
    }

    public function getCustomProductById(int $id)
    {
        return DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'brands.name as brand_name',
            )
            ->where(['products.id' => $id, 'products.delete_flag' => false])
            ->first();
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
}
