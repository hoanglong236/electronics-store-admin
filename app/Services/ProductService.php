<?php

namespace App\Services;

use App\Constants\ConfigConstants;
use App\Http\Requests\Constants\ProductSearchRequestConstants;
use App\Repositories\IProductRepository;
use App\Utils\CommonUtil;

class ProductService
{
    private $productRepository;

    private $storageService;

    public function __construct(
        IProductRepository $iProductRepository, StorageService $storageService
    ) {
        $this->productRepository = $iProductRepository;
        $this->storageService = $storageService;
    }

    public function getProductById(int $productId)
    {
        return $this->productRepository->findById($productId);
    }

    public function getProductsPaginator(int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->productRepository
            ->searchAndPaginate('', ProductSearchRequestConstants::SEARCH_ALL, $itemPerPage);
    }

    public function getSearchProductsPaginator(
        array $productSearchProps, int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchOption = $productSearchProps['searchOption'];
        $searchKeyword = $productSearchProps['searchKeyword'];
        $escapedKeyword = CommonUtil::escapeKeyword($searchKeyword);

        return $this->productRepository
            ->searchAndPaginate($escapedKeyword, $searchOption, $itemPerPage);
    }

    public function createProduct(array $productProps)
    {
        $createAttributes = [];
        $createAttributes['main_image_path'] = $this->storageService
            ->saveFile($productProps['mainImage'], ConfigConstants::FOLDER_PATH_PRODUCT_IMAGES);
        $createAttributes['category_id'] = $productProps['categoryId'];
        $createAttributes['brand_id'] = $productProps['brandId'];
        $createAttributes['name'] = $productProps['name'];
        $createAttributes['slug'] = $productProps['slug'];
        $createAttributes['price'] = $productProps['price'];
        $createAttributes['discount_percent'] = $productProps['discountPercent'];
        $createAttributes['quantity'] = $productProps['quantity'];
        $createAttributes['warranty_period'] = $productProps['warrantyPeriod'];
        $createAttributes['description'] = $productProps['description'];
        $createAttributes['delete_flag'] = false;

        $this->productRepository->create($createAttributes);
    }

    public function updateProduct(array $productProps, int $productId)
    {
        $oldProduct = $this->getProductById($productId);
        if (!$oldProduct) {
            return false;
        }

        $updateAttributes = [];
        if (isset($productProps['mainImage'])) {
            $this->storageService->deleteFile($oldProduct->main_image_path);
            $updateAttributes['main_image_path'] = $this->storageService
                ->saveFile($productProps['mainImage'], ConfigConstants::FOLDER_PATH_PRODUCT_IMAGES);
        }
        $updateAttributes['category_id'] = $productProps['categoryId'];
        $updateAttributes['brand_id'] = $productProps['brandId'];
        $updateAttributes['name'] = $productProps['name'];
        $updateAttributes['slug'] = $productProps['slug'];
        $updateAttributes['price'] = $productProps['price'];
        $updateAttributes['discount_percent'] = $productProps['discountPercent'];
        $updateAttributes['quantity'] = $productProps['quantity'];
        $updateAttributes['warranty_period'] = $productProps['warrantyPeriod'];
        $updateAttributes['description'] = $productProps['description'];

        $this->productRepository->update($updateAttributes, $productId);
    }

    public function deleteProductById(int $productId)
    {
        $this->productRepository->deleteById($productId);
    }

    public function getProductDetails(int $productId)
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
        $images = $this->productRepository->getProductImagesByProductId($productId);
        foreach ($images as $image) {
            $productDetails['images'][] = [
                'id' => $image->id,
                'path' => $image->image_path,
            ];
        }

        return $productDetails;
    }

    public function createProductImages(array $productImageProps)
    {
        $images = $productImageProps['images'];
        foreach ($images as $image) {
            $createAttributes = [];
            $createAttributes['image_path'] = $this->storageService
                ->saveFile($image, ConfigConstants::FOLDER_PATH_PRODUCT_IMAGES);
            $createAttributes['product_id'] = $productImageProps['productId'];

            $this->productRepository->createProductImage($createAttributes);
        }
    }

    public function deleteProductImageById(int $productImageId)
    {
        $deletedProductImage = $this->productRepository->deleteProductImageById($productImageId);
        if ($deletedProductImage) {
            $this->storageService->deleteFile($deletedProductImage->image_path);
        }
    }
}
