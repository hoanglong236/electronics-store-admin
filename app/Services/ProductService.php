<?php

namespace App\Services;

use App\Common\Constants;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductService
{
    private $storageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
    }

    public function findProductById($productId)
    {
        return Product::where(['id' => $productId, 'delete_flag' => false])->first();
    }

    public function listProductsPaginate($itemPerPage = 9)
    {
        return Product::where('delete_flag', false)->paginate($itemPerPage);
    }

    public function createProduct($productPropterties)
    {
        $product = new Product();

        $product->category_id = $productPropterties['categoryId'];
        $product->brand_id = $productPropterties['brandId'];
        $product->name = $productPropterties['name'];
        $product->price = $productPropterties['price'];
        $product->discount_percent = $productPropterties['discountPercent'];
        $product->quantity = $productPropterties['quantity'];
        $product->warranty_period = $productPropterties['warrantyPeriod'];
        $product->description = $productPropterties['description'];
        $product->main_image_path = $this->storageService->saveFile(
            $productPropterties['mainImage'],
            Constants::PRODUCT_IMAGE_PATH
        );
        $product->delete_flag = false;

        $product->save();
    }

    public function updateProduct($productPropterties, $productId)
    {
        $product = $this->findProductById($productId);

        $product->category_id = $productPropterties['categoryId'];
        $product->brand_id = $productPropterties['brandId'];
        $product->name = $productPropterties['name'];
        $product->price = $productPropterties['price'];
        $product->discount_percent = $productPropterties['discountPercent'];
        $product->quantity = $productPropterties['quantity'];
        $product->warranty_period = $productPropterties['warrantyPeriod'];
        $product->description = $productPropterties['description'];
        if (isset($productPropterties['mainImage'])) {
            $this->storageService->deleteFile($product->main_image_path);
            $product->main_image_path = $this->storageService->saveFile(
                $productPropterties['mainImage'],
                Constants::PRODUCT_IMAGE_PATH
            );
        }

        $product->update();
    }

    public function deleteProduct($productId)
    {
        $product = $this->findProductById($productId);

        $this->storageService->deleteFile($product->main_image_path);
        $product->delete_flag = true;

        $product->update();
    }
}
