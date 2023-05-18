<?php

namespace App\Services;

use App\Common\Constants;
use App\Config\Config;
use App\Models\Category;
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

    public function findById($categoryId)
    {
        return Category::findById($categoryId);
    }

    public function getListCategoriesPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return Category::where('delete_flag', false)
            ->latest()
            ->paginate($itemPerPage);
    }

    public function createCategory($categoryProperties)
    {
        $iconPath = $this->storageService->saveFile(
            $categoryProperties['icon'],
            Config::FOLDER_PATH_CATEGORY_ICONS,
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
        $category = $this->findById($categoryId);

        $category->parent_id = $categoryProperties['parentId'] === Constants::NONE_VALUE
            ? null : $categoryProperties['parentId'];
        $category->name = $categoryProperties['name'];
        $category->slug = $categoryProperties['slug'];

        if (isset($categoryProperties['icon'])) {
            $this->storageService->deleteFile($category->icon_path);
            $this->firebaseStorageService->deleteImage($category->icon_path);

            $category->icon_path = $this->storageService->saveFile(
                $categoryProperties['icon'],
                Config::FOLDER_PATH_CATEGORY_ICONS
            );
            $this->firebaseStorageService->uploadImage($category->icon_path);
        }

        $category->save();
    }

    public function deleteCategory($categoryId)
    {
        Category::deleteById($categoryId);
    }

    public function getCategoryIdNameMap()
    {
        return Category::getMapFromIdToName();
    }

    public function getSearchCategoriesPaginator(
        $categorySearchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $categorySearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return DB::table('categories')
            ->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->select('categories.*')
            ->where('categories.delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('categories.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('categories.slug', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('parent.name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('parent.slug', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }
}
