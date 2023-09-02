<?php

namespace App\Services;

use App\Constants\ConfigConstants;
use App\Repositories\ICategoryRepository;
use App\Utils\CommonUtil;

class CategoryService
{
    private $categoryRepository;

    private $storageService;

    public function __construct(
        ICategoryRepository $iCategoryRepository, StorageService $storageService
    ) {
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
        array $searchProps, int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $searchProps['searchKeyword'];
        $escapedKeyword = CommonUtil::escapeKeyword($searchKeyword);

        return $this->categoryRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }

    public function createCategory(array $categoryProps)
    {
        $createAttributes = [];
        $createAttributes['parent_id'] = $categoryProps['parentId'] ?? null;
        $createAttributes['icon_path'] = $this->storageService
            ->saveFile($categoryProps['icon'], ConfigConstants::FOLDER_PATH_CATEGORY_ICONS);
        $createAttributes['name'] = $categoryProps['name'];
        $createAttributes['slug'] = $categoryProps['slug'];
        $createAttributes['delete_flag'] = false;

        return $this->categoryRepository->create($createAttributes);
    }

    public function updateCategory(array $categoryProps, int $categoryId)
    {
        $oldCategory = $this->getCategoryById($categoryId);
        if (!$oldCategory) {
            return;
        }

        $updateAttributes = [];
        if (isset($categoryProps['icon'])) {
            $this->storageService->deleteFile($oldCategory->icon_path);
            $updateAttributes['icon_path'] = $this->storageService
                ->saveFile($categoryProps['icon'], ConfigConstants::FOLDER_PATH_CATEGORY_ICONS);
        }
        $updateAttributes['parent_id'] = $categoryProps['parentId'] ?? null;
        $updateAttributes['name'] = $categoryProps['name'];
        $updateAttributes['slug'] = $categoryProps['slug'];

        return $this->categoryRepository->update($updateAttributes, $categoryId);
    }

    public function deleteCategoryById(int $categoryId)
    {
        return $this->categoryRepository->deleteById($categoryId);
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
