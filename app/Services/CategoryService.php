<?php

namespace App\Services;

use App\Common\Constants;
use App\Config\Config;
use App\Repositories\ICategoryRepository;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    private $categoryRepository;

    private $storageService;
    private $firebaseStorageService;

    public function __construct(
        ICategoryRepository $categoryRepository,
        StorageService $storageService,
        FirebaseStorageService $firebaseStorageService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->storageService = $storageService;
        $this->firebaseStorageService = $firebaseStorageService;
    }

    public function findById($categoryId)
    {
        return $this->categoryRepository->findById($categoryId);
    }

    public function getListCategoriesPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->categoryRepository->paginate($itemPerPage);
    }

    private function saveCategoryIcon($icon)
    {
        $iconPath = $this->storageService->saveFile($icon, Config::FOLDER_PATH_CATEGORY_ICONS);
        if ($iconPath) {
            $this->firebaseStorageService->uploadImage($iconPath);
        }

        return $iconPath;
    }

    private function deleteCategoryIcon($iconPath)
    {
        $this->storageService->deleteFile($iconPath);
        $this->firebaseStorageService->deleteImage($iconPath);
    }

    public function createCategory($categoryProperties)
    {
        $createAttributes = [];

        if ($categoryProperties['parentId'] !== Constants::NONE_VALUE) {
            $createAttributes['parent_id'] = $categoryProperties['parentId'];
        }
        $createAttributes['icon_path'] = $this->saveCategoryIcon($categoryProperties['icon']);
        $createAttributes['name'] = $categoryProperties['name'];
        $createAttributes['slug'] = $categoryProperties['slug'];
        $createAttributes['delete_flag'] = false;

        $this->categoryRepository->create($createAttributes);
    }

    public function updateCategory($categoryProperties, $categoryId)
    {
        $updateAttributes = [];

        if ($categoryProperties['parentId'] !== Constants::NONE_VALUE) {
            $updateAttributes['parent_id'] = $categoryProperties['parentId'];
        }
        if ($categoryProperties['icon']) {
            $oldCategory = $this->categoryRepository->findById($categoryId);
            $this->deleteCategoryIcon($oldCategory->icon_path);

            $updateAttributes['icon_path'] = $this->saveCategoryIcon($categoryProperties['icon']);
        }
        $updateAttributes['name'] = $categoryProperties['name'];
        $updateAttributes['slug'] = $categoryProperties['slug'];

        $this->categoryRepository->update($updateAttributes, $categoryId);
    }

    public function deleteCategory($categoryId)
    {
        $this->categoryRepository->deleteById($categoryId);
    }

    public function getCategoryIdNameMap()
    {
        $miniCategories = $this->categoryRepository->listAll(['id', 'name']);
        $map = [];

        foreach ($miniCategories as $miniCategory) {
            $map[$miniCategory->id] = $miniCategory->name;
        }

        return $map;
    }

    public function getSearchCategoriesPaginator(
        $categorySearchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $categorySearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return $this->categoryRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }
}
