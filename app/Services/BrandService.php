<?php

namespace App\Services;

use App\Constants\ConfigConstants;
use App\Repositories\IBrandRepository;
use App\Utils\CommonUtil;

class BrandService
{
    private $brandRepository;

    private $storageService;

    public function __construct(
        IBrandRepository $iBrandRepository, StorageService $storageService
    ) {
        $this->brandRepository = $iBrandRepository;
        $this->storageService = $storageService;
    }

    public function getBrandById(int $brandId)
    {
        return $this->brandRepository->findById($brandId);
    }

    public function getBrandsPaginator(int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->brandRepository->searchAndPaginate('', $itemPerPage);
    }

    public function getSearchBrandsPaginator(
        array $searchProps, int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $searchProps['searchKeyword'];
        $escapedKeyword = CommonUtil::escapeKeyword($searchKeyword);

        return $this->brandRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }

    public function createBrand(array $brandProps)
    {
        $createAttributes = [];
        $createAttributes['logo_path'] = $this->storageService
            ->saveFile($brandProps['logo'], ConfigConstants::FOLDER_PATH_BRAND_LOGOS);
        $createAttributes['name'] = $brandProps['name'];
        $createAttributes['slug'] = $brandProps['slug'];
        $createAttributes['delete_flag'] = false;

        return $this->brandRepository->create($createAttributes);
    }

    public function updateBrand(array $brandProps, int $brandId)
    {
        $oldBrand = $this->getBrandById($brandId);
        if (!$oldBrand) {
            return;
        }

        $updateAttributes = [];
        if (isset($brandProps['logo'])) {
            $this->storageService->deleteFile($oldBrand->logo_path);
            $updateAttributes['logo_path'] = $this->storageService
                ->saveFile($brandProps['logo'], ConfigConstants::FOLDER_PATH_BRAND_LOGOS);
        }
        $updateAttributes['name'] = $brandProps['name'];
        $updateAttributes['slug'] = $brandProps['slug'];

        return $this->brandRepository->update($updateAttributes, $brandId);
    }

    public function deleteBrandById(int $brandId)
    {
        return $this->brandRepository->deleteById($brandId);
    }

    public function getMapFromBrandIdToBrand(bool $withDeleted = false)
    {
        $miniBrands = $this->brandRepository
            ->listAll(['id', 'name', 'delete_flag'], $withDeleted);
        $map = [];

        foreach ($miniBrands as $miniBrand) {
            $map[$miniBrand->id] = $miniBrand;
        }
        return $map;
    }
}
