<?php

namespace App\Services;

use App\Common\Constants;
use App\Config\Config;
use App\Repositories\IBrandRepository;
use Illuminate\Support\Facades\Log;

class BrandService
{
    private $brandRepository;

    private $storageService;
    private $firebaseStorageService;

    public function __construct(
        IBrandRepository $brandRepository,
        StorageService $storageService,
        FirebaseStorageService $firebaseStorageService
    ) {
        $this->brandRepository = $brandRepository;
        $this->storageService = $storageService;
        $this->firebaseStorageService = $firebaseStorageService;
    }

    public function getBrandById($brandId)
    {
        return $this->brandRepository->findById($brandId);
    }

    public function getListBrandsPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->brandRepository->paginate($itemPerPage);
    }

    private function saveBrandLogoToStorage($logo)
    {
        $logoPath = $this->storageService->saveFile($logo, Config::FOLDER_PATH_BRAND_LOGOS);
        if ($logoPath) {
            $this->firebaseStorageService->uploadImage($logoPath);
        }

        return $logoPath;
    }

    private function deleteBrandLogoFromStorage($logoPath)
    {
        $this->storageService->deleteFile($logoPath);
        $this->firebaseStorageService->deleteImage($logoPath);
    }

    public function createBrand($brandProperties)
    {
        $createAttributes = [];

        $createAttributes['logo_path'] = $this->saveBrandLogoToStorage($brandProperties['logo']);
        $createAttributes['name'] = $brandProperties['name'];
        $createAttributes['slug'] = $brandProperties['slug'];
        $createAttributes['delete_flag'] = false;

        $this->brandRepository->create($createAttributes);
    }

    public function updateBrand($brandProperties, $brandId)
    {
        $oldBrand = $this->getBrandById($brandId);
        if (!$oldBrand) {
            return;
        }

        $updateAttributes = [];

        if (isset($brandProperties['logo'])) {
            $this->deleteBrandLogoFromStorage($oldBrand->logo_path);
            $updateAttributes['logo_path'] = $this->saveBrandLogoToStorage($brandProperties['logo']);
        }

        $updateAttributes['name'] = $brandProperties['name'];
        $updateAttributes['slug'] = $brandProperties['slug'];

        $this->brandRepository->update($updateAttributes, $brandId);
    }

    public function deleteBrandById($brandId)
    {
        $this->brandRepository->deleteById($brandId);
    }

    public function getBrandIdNameMap()
    {
        $miniBrands = $this->brandRepository->listAll(['id', 'name']);
        $map = [];

        foreach ($miniBrands as $miniBrand) {
            $map[$miniBrand->id] = $miniBrand->name;
        }

        return $map;
    }

    public function getSearchBrandsPaginator(
        $searchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $searchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return $this->brandRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }
}
