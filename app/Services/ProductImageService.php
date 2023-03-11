<?php

namespace App\Services;

use App\Common\Constants;
use Illuminate\Support\Facades\Log;
use App\Models\ProductImage;

class ProductImageService
{
    private $storageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
    }

    public function listProductImagesInProduct($productId) {
        return ProductImage::where('product_id', $productId)->get();
    }

    public function createProductImages($productImageProperties)
    {
        $productId = $productImageProperties['productId'];
        $images = $productImageProperties['images'];

        foreach ($images as $image) {
            $productImage = new ProductImage();

            $productImage->product_id = $productId;
            $productImage->image_path = $this->storageService->saveFile($image, Constants::PRODUCT_IMAGE_PATH);

            $productImage->save();
        }
    }

    public function deleteProductImage($productImageId)
    {
        $productImage = ProductImage::find($productImageId);
        $this->storageService->deleteFile($productImage->image_path);
        $productImage->delete();
    }

    public function deleteProductImagesInProduct($productId) {
        $productImages = ProductImage::where('product_id', $productId)->get();
        foreach ($productImages as $productImage) {
            $this->storageService->deleteFile($productImage->image_path);
            $productImage->delete();
        }
    }
}
