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

    public function __construct(ICategoryRepository $iCategoryRepository, StorageService $storageService)
    {
        $this->categoryRepository = $iCategoryRepository;
        $this->storageService = $storageService;
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

    public function createCategory(array $categoryProperties)
    {
        $createAttributes = [];

        if ($categoryProperties['parentId'] !== CommonConstants::NONE_VALUE) {
            $createAttributes['parent_id'] = $categoryProperties['parentId'];
        }
        $createAttributes['icon_path'] = $this->storageService
            ->saveFile($categoryProperties['icon'], ConfigConstants::FOLDER_PATH_CATEGORY_ICONS);
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
            $this->storageService->deleteFile($oldCategory->icon_path);
            $updateAttributes['icon_path'] = $this->storageService
                ->saveFile($categoryProperties['icon'], ConfigConstants::FOLDER_PATH_CATEGORY_ICONS);
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
