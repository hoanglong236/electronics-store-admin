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

    public function __construct(IProductRepository $iProductRepository, StorageService $storageService)
    {
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
        array $productSearchProperties,
        int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchOption = $productSearchProperties['searchOption'];
        $searchKeyword = $productSearchProperties['searchKeyword'];
        $escapedKeyword = CommonUtil::escapeKeyword($searchKeyword);

        return $this->productRepository
            ->searchAndPaginate($escapedKeyword, $searchOption, $itemPerPage);
    }

    public function createProduct(array $productProperties)
    {
        $createAttributes = [];

        $createAttributes['main_image_path'] = $this->storageService
            ->saveFile($productProperties['mainImage'], ConfigConstants::FOLDER_PATH_PRODUCT_IMAGES);
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

    public function updateProduct(array $productProperties, int $productId)
    {
        $oldProduct = $this->getProductById($productId);
        if (!$oldProduct) {
            return false;
        }

        $updateAttributes = [];
        if (isset($productProperties['mainImage'])) {
            $this->storageService->deleteFile($oldProduct->main_image_path);
            $updateAttributes['main_image_path'] = $this->storageService
                ->saveFile($productProperties['mainImage'], ConfigConstants::FOLDER_PATH_PRODUCT_IMAGES);
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

    public function createProductImages(array $productImageProperties)
    {
        $images = $productImageProperties['images'];
        foreach ($images as $image) {
            $createAttributes = [];
            $createAttributes['image_path'] = $this->storageService
                ->saveFile($image, ConfigConstants::FOLDER_PATH_PRODUCT_IMAGES);
            $createAttributes['product_id'] = $productImageProperties['productId'];

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
