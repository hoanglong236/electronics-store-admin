<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private $categoryService;
    private $storageService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->storageService = new StorageService();
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->listCategories();
        $categoryNameMap = [];
        foreach ($categories as $category) {
            $categoryNameMap[$category->id] = $category->name;
        }

        return view('pages.category.list-categories', [
            'pageTitle' => 'List categories',
            'categories' => $categories,
            'categoryNameMap' => $categoryNameMap,
        ]);
    }

    public function create(Request $request)
    {
        $categories = $this->categoryService->listCategories();
        $categoryNameMap = [];
        foreach ($categories as $category) {
            $categoryNameMap[$category->id] = $category->name;
        }

        return view('pages.category.create-category', [
            'pageTitle' => 'Create category',
            'categoryNameMap' => $categoryNameMap,
        ]);
    }

    public function createHandler(CategoryRequest $categoryRequest)
    {
        $parentCategoryId = $categoryRequest->post('parentId');
        $categoryProperties['parentId'] =
            $parentCategoryId === Constants::NONE_VALUE ? null : (int) $parentCategoryId;

        if ($categoryRequest->hasFile('icon')) {
            $categoryProperties['iconPath'] = $this->storageService->saveFile(
                $categoryRequest->file('icon'),
                Constants::CATEGORY_ICON_PATH
            );
        }
        $categoryProperties['name'] = $categoryRequest->post('name');
        $this->categoryService->createCategory($categoryProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    public function update(Request $request, $categoryId)
    {
        $categories = $this->categoryService->listCategories();
        $categoryNameMap = [];
        foreach ($categories as $category) {
            $categoryNameMap[$category->id] = $category->name;
        }

        return view('pages.category.update-category', [
            'pageTitle' => 'Update category',
            'category' => $this->categoryService->findCategoryById($categoryId),
            'categoryNameMap' => $categoryNameMap
        ]);
    }

    public function updateHandler(CategoryRequest $categoryRequest, $categoryId)
    {
        $parentCategoryId = $categoryRequest->post('parentId');
        $categoryProperties['parentId'] =
            $parentCategoryId === Constants::NONE_VALUE ? null : (int) $parentCategoryId;

        if ($categoryRequest->hasFile('icon')) {
            $categoryProperties['iconPath'] = $this->storageService->saveFile(
                $categoryRequest->file('icon'),
                Constants::CATEGORY_ICON_PATH
            );
        }
        $categoryProperties['name'] = $categoryRequest->post('name');
        $this->categoryService->updateCategory($categoryProperties, $categoryId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    // TODO: validate here
    public function delete(Request $request, $categoryId)
    {
        $this->categoryService->deleteCategory($categoryId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }
}
