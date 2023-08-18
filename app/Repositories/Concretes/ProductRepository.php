<?php

namespace App\Repositories\Concretes;

use App\Http\Requests\Constants\ProductSearchRequestConstants;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\IProductRepository;
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
        return $this->update(['delete_flag' => true], $id);
    }

    public function searchAndPaginate(
        string $escapedKeyword, string $searchOption, int $itemPerPage
    ) {
        $queryBuilder = DB::table('products');

        if (strlen($escapedKeyword) > 0) {
            switch ($searchOption) {
                case ProductSearchRequestConstants::SEARCH_ALL:
                    $queryBuilder
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
                    break;
                case ProductSearchRequestConstants::SEARCH_CATEGORY:
                    $queryBuilder
                        ->join('categories', 'categories.id', '=', 'products.category_id')
                        ->where(function ($query) use ($escapedKeyword) {
                            $query->Where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                                ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%');
                        });
                    break;
                case ProductSearchRequestConstants::SEARCH_BRAND:
                    $queryBuilder
                        ->join('brands', 'brands.id', '=', 'products.brand_id')
                        ->where(function ($query) use ($escapedKeyword) {
                            $query->Where('brands.name', 'LIKE', '%' . $escapedKeyword . '%')
                                ->orWhere('brands.slug', 'LIKE', '%' . $escapedKeyword . '%');
                        });
                    break;
            }
        }

        return $queryBuilder->where('products.delete_flag', false)
            ->addSelect([
                'products.id',
                'products.name',
                'products.price',
                'products.discount_percent',
                'products.quantity',
                'products.main_image_path'
            ])
            ->latest('products.id')
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

    public function getProductImagesByProductId(int $productId)
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
