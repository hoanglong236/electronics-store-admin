<?php

namespace App\Services;

use App\Common\Constants;
use App\DataFilterConstants\CategorySearchOptionConstants;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    private $storageService;
    private $firebaseStorageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
        $this->firebaseStorageService = new FirebaseStorageService();
    }

    public function getCategoryById($categoryId)
    {
        return Category::where([
            'delete_flag' => false,
            'id' => $categoryId,
        ])->first();
    }

    public function getListCategoriesPaginator($limit = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return Category::where('delete_flag', false)
            ->latest()
            ->paginate($limit);
    }

    public function createCategory($categoryProperties)
    {
        $iconPath = $this->storageService->saveFile(
            $categoryProperties['icon'],
            Constants::CATEGORY_ICON_PATH
        );
        $parentCategoryId = $categoryProperties['parentId'] === Constants::NONE_VALUE
            ? null : $categoryProperties['parentId'];

        Category::create([
            'parent_id' => $parentCategoryId,
            'name' => $categoryProperties['name'],
            'slug' => $categoryProperties['slug'],
            'icon_path' => $iconPath,
            'delete_flag' => false,
        ]);
        $this->firebaseStorageService->uploadImage($iconPath);
    }

    public function updateCategory($categoryProperties, $categoryId)
    {
        $category = $this->getCategoryById($categoryId);

        $category->parent_id = $categoryProperties['parentId'] === Constants::NONE_VALUE
            ? null : $categoryProperties['parentId'];
        $category->name = $categoryProperties['name'];
        $category->slug = $categoryProperties['slug'];

        if (isset($categoryProperties['icon'])) {
            $this->storageService->deleteFile($category->icon_path);
            $this->firebaseStorageService->deleteImage($category->icon_path);

            $category->icon_path = $this->storageService->saveFile(
                $categoryProperties['icon'],
                Constants::CATEGORY_ICON_PATH
            );
            $this->firebaseStorageService->uploadImage($category->icon_path);
        }

        $category->save();
    }

    public function deleteCategory($categoryId)
    {
        $category = $this->getCategoryById($categoryId);
        $category->delete_flag = true;

        $category->save();
    }

    public function getCategoryIdNameMap()
    {
        $categories = Category::where('delete_flag', false)->get();
        $map = [];
        foreach ($categories as $category) {
            $map[$category->id] = $category->name;
        }

        return $map;
    }

    public function getSearchCategoriesPaginator(
        $categorySearchProperties,
        $limit = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $categorySearchProperties['searchKeyword'];
        $searchOption = $categorySearchProperties['searchOption'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $queryBuilder = $this->getSearchCategoriesQueryBuilder($escapedKeyword, $searchOption);
        if (is_null($queryBuilder)) {
            return new LengthAwarePaginator([], 0, $limit);
        }

        return $queryBuilder->latest()
            ->paginate($limit);
    }

    private function getSearchCategoriesQueryBuilder($escapedKeyword, $searchOption)
    {
        switch ($searchOption) {
            case CategorySearchOptionConstants::SEARCH_ALL:
                return $this->getSearchCategoriesByAllQueryBuilder($escapedKeyword);
            case CategorySearchOptionConstants::SEARCH_NAME:
                return $this->getSearchCategoriesByNameQueryBuilder($escapedKeyword);
            case CategorySearchOptionConstants::SEARCH_SLUG:
                return $this->getSearchCategoriesBySlugQueryBuilder($escapedKeyword);
            case CategorySearchOptionConstants::SEARCH_PARENT:
                return $this->getSearchCategoriesByParentNameQueryBuilder($escapedKeyword);
            default:
                return null;
        }
    }

    private function getSearchCategoriesByAllQueryBuilder($escapedKeyword)
    {
        return DB::table('categories')
            ->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->select('categories.*')
            ->where('categories.delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('parent.name', 'LIKE', '%' . $escapedKeyword . '%');
            });
    }

    private function getSearchCategoriesByNameQueryBuilder($escapedKeyword)
    {
        return Category::where([
            'delete_flag' => false,
            ['name', 'LIKE', '%' . $escapedKeyword . '%']
        ]);
    }

    private function getSearchCategoriesBySlugQueryBuilder($escapedKeyword)
    {
        return Category::where([
            'delete_flag' => false,
            ['slug', 'LIKE', '%' . $escapedKeyword . '%']
        ]);
    }

    private function getSearchCategoriesByParentNameQueryBuilder($escapedKeyword)
    {
        return DB::table('categories')
            ->join('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->select('categories.*')
            ->where('categories.delete_flag', false)
            ->where('parent.name', 'LIKE', '%' . $escapedKeyword . '%');
    }
}
