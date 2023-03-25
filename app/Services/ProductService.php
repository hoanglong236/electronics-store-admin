<?php

namespace App\Services;

use App\Common\Constants;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

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

    public function listProductsPaginate($itemPerPage)
    {
        return Product::where('delete_flag', false)->paginate($itemPerPage);
    }

    public function createProduct($productProperties)
    {
        $product = new Product();

        $product->category_id = $productProperties['categoryId'];
        $product->brand_id = $productProperties['brandId'];
        $product->name = $productProperties['name'];
        $product->slug = $productProperties['slug'];
        $product->price = $productProperties['price'];
        $product->discount_percent = $productProperties['discountPercent'];
        $product->quantity = $productProperties['quantity'];
        $product->warranty_period = $productProperties['warrantyPeriod'];
        $product->description = $productProperties['description'];
        $product->main_image_path = $this->storageService->saveFile(
            $productProperties['mainImage'],
            Constants::PRODUCT_IMAGE_PATH
        );
        $product->delete_flag = false;

        $product->save();

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

        $product->update();
    }

    public function deleteProduct($productId)
    {
        $product = $this->findProductById($productId);

        $this->storageService->deleteFile($product->main_image_path);
        $this->productImageService->deleteProductImagesInProduct($productId);
        $product->delete_flag = true;

        $product->update();
    }
}
