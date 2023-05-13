<?php

namespace App\Services;

use App\Common\Constants;
use App\DataFilterConstants\ProductSearchOptionConstants;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    private $storageService;
    private $firebaseStorageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
        $this->firebaseStorageService = new FirebaseStorageService();
    }

    public function getProductById($productId)
    {
        return Product::where(['id' => $productId, 'delete_flag' => false])->first();
    }

    public function getCustomProductById($productId)
    {
        return DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'brands.name as brand_name',
            )
            ->where(['products.delete_flag' => false, 'products.id' => $productId])
            ->first();
    }

    public function getListProductsPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return Product::where('delete_flag', false)
            ->latest()
            ->paginate($itemPerPage);
    }

    public function createProduct($productProperties)
    {
        $productMainImage = $this->storageService->saveFile(
            $productProperties['mainImage'],
            Constants::PRODUCT_IMAGE_PATH
        );
        $product = Product::create([
            'category_id' => $productProperties['categoryId'],
            'brand_id' => $productProperties['brandId'],
            'name' => $productProperties['name'],
            'slug' => $productProperties['slug'],
            'price' => $productProperties['price'],
            'discount_percent' => $productProperties['discountPercent'],
            'quantity' => $productProperties['quantity'],
            'warranty_period' => $productProperties['warrantyPeriod'],
            'description' => $productProperties['description'],
            'main_image_path' => $productMainImage,
            'delete_flag' => false,
        ]);
        $this->firebaseStorageService->uploadImage($productMainImage);

        $this->createProductImages([
            'productId' => $product->id,
            'images' => $productProperties['images']
        ]);
    }

    public function updateProduct($productProperties, $productId)
    {
        $product = $this->getProductById($productId);

        $product->category_id = $productProperties['categoryId'];
        $product->brand_id = $productProperties['brandId'];
        $product->name = $productProperties['name'];
        $product->slug = $productProperties['slug'];
        $product->price = $productProperties['price'];
        $product->discount_percent = $productProperties['discountPercent'];
        $product->quantity = $productProperties['quantity'];
        $product->warranty_period = $productProperties['warrantyPeriod'];
        $product->description = $productProperties['description'];

        if (isset($productProperties['mainImage'])) {
            $this->storageService->deleteFile($product->main_image_path);
            $this->firebaseStorageService->deleteImage($product->main_image_path);

            $product->main_image_path = $this->storageService->saveFile(
                $productProperties['mainImage'],
                Constants::PRODUCT_IMAGE_PATH
            );
            $this->firebaseStorageService->uploadImage($product->main_image_path);
        }

        $product->save();
    }

    public function deleteProduct($productId)
    {
        $product = $this->getProductById($productId);
        $product->delete_flag = true;

        $product->save();
    }

    public function getSearchProductsPaginator(
        $productSearchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchOption = $productSearchProperties['searchOption'];
        $searchKeyword = $productSearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $queryBuilder = $this->getSearchProductsQueryBuilder($escapedKeyword, $searchOption);
        if (is_null($queryBuilder)) {
            return new LengthAwarePaginator([], 0, $itemPerPage);
        }

        return $queryBuilder->latest()
            ->paginate($itemPerPage);
    }

    private function getSearchProductsQueryBuilder($escapedKeyword, $searchOption)
    {
        switch ($searchOption) {
            case ProductSearchOptionConstants::SEARCH_ALL:
                return $this->getSearchProductsByAllQueryBuilder($escapedKeyword);
            case ProductSearchOptionConstants::SEARCH_NAME:
                return $this->getSearchProductsByNameQueryBuilder($escapedKeyword);
            case ProductSearchOptionConstants::SEARCH_SLUG:
                return $this->getSearchProductsBySlugQueryBuilder($escapedKeyword);
            case ProductSearchOptionConstants::SEARCH_CATEGORY:
                return $this->getSearchProductsByCategoryNameQueryBuilder($escapedKeyword);
            case ProductSearchOptionConstants::SEARCH_BRAND:
                return $this->getSearchProductsByBrandNameQueryBuilder($escapedKeyword);
            default:
                return null;
        }
    }

    private function getSearchProductsByAllQueryBuilder($escapedKeyword)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('products.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('products.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.name', 'LIKE', '%' . $escapedKeyword . '%');
            });
    }

    private function getSearchProductsByNameQueryBuilder($escapedKeyword)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('products.name', 'LIKE', '%' . $escapedKeyword . '%');
    }

    private function getSearchProductsBySlugQueryBuilder($escapedKeyword)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('products.slug', 'LIKE', '%' . $escapedKeyword . '%');
    }

    private function getSearchProductsByCategoryNameQueryBuilder($escapedKeyword)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('categories.name', 'LIKE', '%' . $escapedKeyword . '%');
    }

    private function getSearchProductsByBrandNameQueryBuilder($escapedKeyword)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('brands.name', 'LIKE', '%' . $escapedKeyword . '%');
    }

    private function getBaseSearchProductsQueryBuilder()
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

    public function getProductImagesByProductId($productId, $resultAsCollection = false)
    {
        $result = ProductImage::where('product_id', $productId)->get();
        return $resultAsCollection ? $result : $result->all();
    }

    public function createProductImages($productImageProperties)
    {
        $images = $productImageProperties['images'];

        foreach ($images as $image) {
            $imagePath = $this->storageService->saveFile($image, Constants::PRODUCT_IMAGE_PATH);
            $this->firebaseStorageService->uploadImage($imagePath);

            ProductImage::create([
                'product_id' => $productImageProperties['productId'],
                'image_path' => $imagePath,
            ]);
        }
    }

    public function deleteProductImage($productImageId)
    {
        $productImage = ProductImage::find($productImageId);

        $this->storageService->deleteFile($productImage->image_path);
        $this->firebaseStorageService->deleteImage($productImage->image_path);

        $productImage->delete();
    }
}
