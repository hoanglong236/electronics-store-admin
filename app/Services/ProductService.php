<?php

namespace App\Services;

use App\Common\Constants;
use App\Config\Config;
use App\DataFilterConstants\ProductSearchOptionConstants;
use App\Repositories\IProductRepository;
use Illuminate\Support\Facades\Log;

class ProductService
{
    private $productRepository;

    private $storageService;
    private $firebaseStorageService;

    public function __construct(
        IProductRepository $productRepository,
        StorageService $storageService,
        FirebaseStorageService $firebaseStorageService
    ) {
        $this->productRepository = $productRepository;
        $this->storageService = $storageService;
        $this->firebaseStorageService = $firebaseStorageService;
    }

    public function getProductById($productId)
    {
        return $this->productRepository->findById($productId);
    }

    public function getProductsPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->productRepository->searchAndPaginate(
            '',
            ProductSearchOptionConstants::SEARCH_ALL,
            $itemPerPage
        );
    }

    public function getSearchProductsPaginator(
        $productSearchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchOption = $productSearchProperties['searchOption'];
        $searchKeyword = $productSearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return $this->productRepository->searchAndPaginate(
            $escapedKeyword,
            $searchOption,
            $itemPerPage
        );
    }

    private function saveProductImageToStorage($image)
    {
        $imagePath = $this->storageService->saveFile($image, Config::FOLDER_PATH_CATEGORY_ICONS);
        if ($imagePath) {
            $this->firebaseStorageService->uploadImage($imagePath);
        }

        return $imagePath;
    }

    private function deleteProductImageFromStorage($imagePath)
    {
        $this->storageService->deleteFile($imagePath);
        $this->firebaseStorageService->deleteImage($imagePath);
    }

    public function createProduct($productProperties)
    {
        $createAttributes = [];

        $createAttributes['main_image_path'] = $this->saveProductImageToStorage($productProperties['mainImage']);
        $createAttributes['category_id'] = $productProperties['categoryId'];
        $createAttributes['brand_id'] = $productProperties['brandId'];
        $createAttributes['name'] = $productProperties['name'];
        $createAttributes['slug'] = $productProperties['slug'];
        $createAttributes['price'] = $productProperties['price'];
        $createAttributes['discount_percent'] = $productProperties['discountPercent'];
        $createAttributes['quantity'] = $productProperties['quantity'];
        $createAttributes['warranty_period'] = $productProperties['warrantyPeriod'];
        $createAttributes['description'] = $productProperties['description'];
        $createAttributes['delete_flag'] = false;

        $this->productRepository->create($createAttributes);
    }

    public function updateProduct($productProperties, $productId)
    {
        $oldProduct = $this->getProductById($productId);
        if (!$oldProduct) {
            return false;
        }

        $updateAttributes = [];

        if (isset($productProperties['mainImage'])) {
            $this->deleteProductImageFromStorage($oldProduct->main_image_path);
            $updateAttributes['main_image_path'] = $this->saveProductImageToStorage($productProperties['mainImage']);
        }
        $updateAttributes['category_id'] = $productProperties['categoryId'];
        $updateAttributes['brand_id'] = $productProperties['brandId'];
        $updateAttributes['name'] = $productProperties['name'];
        $updateAttributes['slug'] = $productProperties['slug'];
        $updateAttributes['price'] = $productProperties['price'];
        $updateAttributes['discount_percent'] = $productProperties['discountPercent'];
        $updateAttributes['quantity'] = $productProperties['quantity'];
        $updateAttributes['warranty_period'] = $productProperties['warrantyPeriod'];
        $updateAttributes['description'] = $productProperties['description'];

        $this->productRepository->update($updateAttributes, $productId);
    }

    public function deleteProductById($productId)
    {
        $this->productRepository->deleteById($productId);
    }

    public function getProductDetails($productId)
    {
        $productDetails = [];

        $customProduct = $this->productRepository->getCustomProductById($productId);
        $productDetails['productInfo'] = [
            'id' => $customProduct->id,
            'name' => $customProduct->name,
            'slug' => $customProduct->slug,
            'price' => $customProduct->price,
            'discountPercent' => $customProduct->discount_percent,
            'quantity' => $customProduct->quantity,
            'warrantyPeriod' => $customProduct->warranty_period,
            'description' => $customProduct->description,
            'mainImagePath' => $customProduct->main_image_path,
            'createdAt' => $customProduct->created_at,
            'updatedAt' => $customProduct->updated_at,
            'categoryName' => $customProduct->category_name,
            'brandName' => $customProduct->brand_name,
        ];

        $productDetails['images'] = [];
        $images = $this->productRepository->retrieveProductImagesByProductId($productId);
        foreach ($images as $image) {
            $productDetails['images'][] = [
                'id' => $image->id,
                'path' => $image->image_path,
            ];
        }

        return $productDetails;
    }

    public function createProductImages($productImageProperties)
    {
        $images = $productImageProperties['images'];
        foreach ($images as $image) {
            $createAttributes = [];

            $createAttributes['image_path'] = $this->saveProductImageToStorage($image);
            $createAttributes['product_id'] = $productImageProperties['productId'];

            $this->productRepository->createProductImage($createAttributes);
        }
    }

    public function deleteProductImageById($productImageId)
    {
        $deletedProductImage = $this->productRepository->deleteProductImageById($productImageId);
        if ($deletedProductImage) {
            $this->deleteProductImageFromStorage($deletedProductImage->image_path);
        }
    }
}
