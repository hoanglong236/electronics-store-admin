<?php

namespace App\Services;

use App\Common\Constants;
use App\DataFilterConstants\CategorySearchOptionConstants;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    private $storageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
    }

    public function getCategoryById($categoryId)
    {
        return Category::where([
            'delete_flag' => false,
            'id' => $categoryId,
        ])->first();
    }

    public function listCategories()
    {
        return Category::where('delete_flag', false)->get();
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
            $category->icon_path = $this->storageService->saveFile($categoryProperties['icon'], Constants::CATEGORY_ICON_PATH);
        }

        $category->save();
    }

    public function deleteCategory($categoryId)
    {
        $category = $this->getCategoryById($categoryId);
        $category->delete_flag = true;

        $category->save();
    }

    public function deleteCategoryTree($categoryId)
    {
        DB::statement(
            "WITH RECURSIVE category_tree AS (
                SELECT * FROM categories WHERE categories.id = ?
                UNION ALL
                SELECT categories.* FROM category_tree
                INNER JOIN categories ON categories.parent_id = category_tree.id
            )
            UPDATE categories SET deleted_flag = FALSE WHERE id IN (
                SELECT category_tree.id FROM category_tree
                WHERE category_tree.deleted_flag = FALSE
            )",
            [$categoryId]
        );
    }

    public function getCategoryIdNameMap()
    {
        $categories = $this->listCategories();
        $map = [];
        foreach ($categories as $category) {
            $map[$category->id] = $category->name;
        }

        return $map;
    }

    public function searchCategories($categorySearchProperties)
    {
        $searchKeyword = $categorySearchProperties['searchKeyword'];
        $searchOption = $categorySearchProperties['searchOption'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $queryBuilder = $this->getSearchCategoriesQueryBuilder($escapedKeyword, $searchOption);
        if (is_null($queryBuilder)) {
            return [];
        }

        return $queryBuilder->get();
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
