<?php

namespace App\Services;

use App\Common\Constants;
use App\DataFilterConstants\ProductSearchOptionConstants;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    private $storageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
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

    public function listProductsPaginate($itemPerPage)
    {
        return Product::where('delete_flag', false)->paginate($itemPerPage);
    }

    public function createProduct($productProperties)
    {
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
            'main_image_path' => $this->storageService->saveFile(
                $productProperties['mainImage'],
                Constants::PRODUCT_IMAGE_PATH
            ),
            'delete_flag' => false,
        ]);

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
            $product->main_image_path = $this->storageService->saveFile(
                $productProperties['mainImage'],
                Constants::PRODUCT_IMAGE_PATH
            );
        }

        $product->save();
    }

    public function deleteProduct($productId)
    {
        $product = $this->getProductById($productId);

        $this->storageService->deleteFile($product->main_image_path);
        $this->deleteProductImagesInProduct($productId);
        $product->delete_flag = true;

        $product->save();
    }

    public function searchProductsPaginate($productSearchProperties, $itemPerPage)
    {
        $searchOption = $productSearchProperties['searchOption'];
        $searchKeyword = $productSearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        switch ($searchOption) {
            case ProductSearchOptionConstants::SEARCH_ALL:
                return $this->searchProductsByAll($escapedKeyword, $itemPerPage);
            case ProductSearchOptionConstants::SEARCH_NAME:
                return $this->searchProductsByName($escapedKeyword, $itemPerPage);
            case ProductSearchOptionConstants::SEARCH_SLUG:
                return $this->searchProductsBySlug($escapedKeyword, $itemPerPage);
            case ProductSearchOptionConstants::SEARCH_CATEGORY:
                return $this->searchProductsByCategoryName($escapedKeyword, $itemPerPage);
            case ProductSearchOptionConstants::SEARCH_BRAND:
                return $this->searchProductsByBrandName($escapedKeyword, $itemPerPage);
            default:
                return [];
        }
    }

    private function searchProductsByAll($escapedKeyword, $itemPerPage)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('products.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('products.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('brands.name', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->paginate($itemPerPage);
    }

    private function searchProductsByName($escapedKeyword, $itemPerPage)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('products.name', 'LIKE', '%' . $escapedKeyword . '%')
            ->paginate($itemPerPage);
    }

    private function searchProductsBySlug($escapedKeyword, $itemPerPage)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('products.slug', 'LIKE', '%' . $escapedKeyword . '%')
            ->paginate($itemPerPage);
    }

    private function searchProductsByCategoryName($escapedKeyword, $itemPerPage)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
            ->paginate($itemPerPage);
    }

    private function searchProductsByBrandName($escapedKeyword, $itemPerPage)
    {
        return $this->getBaseSearchProductsQueryBuilder()
            ->where('brands.name', 'LIKE', '%' . $escapedKeyword . '%')
            ->paginate($itemPerPage);
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

    public function getProductImagesByProductId($productId)
    {
        return ProductImage::where('product_id', $productId)->get();
    }

    public function createProductImages($productImageProperties)
    {
        $images = $productImageProperties['images'];

        foreach ($images as $image) {
            $imagePath = $this->storageService->saveFile($image, Constants::PRODUCT_IMAGE_PATH);

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
        $productImage->delete();
    }

    private function deleteProductImagesInProduct($productId)
    {
        $productImages = ProductImage::where('product_id', $productId)->get();

        foreach ($productImages as $productImage) {
            $this->storageService->deleteFile($productImage->image_path);
            $productImage->delete();
        }
    }
}
