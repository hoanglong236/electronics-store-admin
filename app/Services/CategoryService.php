<?php

namespace App\Services;

use App\Constants\CommonConstants;
use App\Constants\ConfigConstants;
use App\Repositories\ICategoryRepository;
use App\Utils\CommonUtil;

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

    public function getCategoryById(int $categoryId)
    {
        return $this->categoryRepository->findById($categoryId);
    }

    public function getCategoriesPaginator(int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->categoryRepository->searchAndPaginate('', $itemPerPage);
    }

    public function getSearchCategoriesPaginator(
        array $searchProperties,
        int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $searchProperties['searchKeyword'];
        $escapedKeyword = CommonUtil::escapeKeyword($searchKeyword);

        return $this->categoryRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }

    private function saveCategoryIconToStorage($icon)
    {
        $iconPath = $this->storageService->saveFile($icon, ConfigConstants::FOLDER_PATH_CATEGORY_ICONS);
        if ($iconPath) {
            $this->firebaseStorageService->uploadImage($iconPath);
        }

        return $iconPath;
    }

    private function deleteCategoryIconFromStorage(string $iconPath)
    {
        $this->storageService->deleteFile($iconPath);
        $this->firebaseStorageService->deleteImage($iconPath);
    }

    public function createCategory(array $categoryProperties)
    {
        $createAttributes = [];

        if ($categoryProperties['parentId'] !== CommonConstants::NONE_VALUE) {
            $createAttributes['parent_id'] = $categoryProperties['parentId'];
        }
        $createAttributes['icon_path'] = $this->saveCategoryIconToStorage($categoryProperties['icon']);
        $createAttributes['name'] = $categoryProperties['name'];
        $createAttributes['slug'] = $categoryProperties['slug'];
        $createAttributes['delete_flag'] = false;

        $this->categoryRepository->create($createAttributes);
    }

    public function updateCategory(array $categoryProperties, int $categoryId)
    {
        $oldCategory = $this->getCategoryById($categoryId);
        if (!$oldCategory) {
            return;
        }

        $updateAttributes = [];

        if (isset($categoryProperties['icon'])) {
            $this->deleteCategoryIconFromStorage($oldCategory->icon_path);
            $updateAttributes['icon_path'] = $this->saveCategoryIconToStorage($categoryProperties['icon']);
        }
        if ($categoryProperties['parentId'] !== CommonConstants::NONE_VALUE) {
            $updateAttributes['parent_id'] = $categoryProperties['parentId'];
        } else {
            $updateAttributes['parent_id'] = null;
        }
        $updateAttributes['name'] = $categoryProperties['name'];
        $updateAttributes['slug'] = $categoryProperties['slug'];

        $this->categoryRepository->update($updateAttributes, $categoryId);
    }

    public function deleteCategoryById(int $categoryId)
    {
        $this->categoryRepository->deleteById($categoryId);
    }

    public function getMapFromCategoryIdToCategory(bool $withDeleted = false)
    {
        $miniCategories = $this->categoryRepository->listAll(
            ['id', 'name', 'delete_flag'],
            $withDeleted
        );
        $map = [];

        foreach ($miniCategories as $miniCategory) {
            $map[$miniCategory->id] = $miniCategory;
        }

        return $map;
    }
}
