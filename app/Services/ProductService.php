<?php

namespace App\Services;

use App\Common\Constants;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    private $storageService;
    private $productImageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
        $this->productImageService = new ProductImageService();
    }

    public function findProductById($productId)
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

        $this->productImageService->createProductImages([
            'productId' => $product->id,
            'images' => $productProperties['images']
        ]);
    }

    public function updateProduct($productProperties, $productId)
    {
        $product = $this->findProductById($productId);

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
        $product = $this->findProductById($productId);

        $this->storageService->deleteFile($product->main_image_path);
        $this->productImageService->deleteProductImagesInProduct($productId);
        $product->delete_flag = true;

        $product->save();
    }
}
