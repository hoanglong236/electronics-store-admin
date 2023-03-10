<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    private $categoryService;
    private $storageService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
        $this->storageService = new StorageService();
    }

    public function index()
    {
        $categories = $this->categoryService->listCategories();
        $categoryIdNameMap = [];
        foreach ($categories as $category) {
            $categoryIdNameMap[$category->id] = $category->name;
        }

        return view('pages.category.list-categories', [
            'pageTitle' => 'List categories',
            'categories' => $categories,
            'categoryIdNameMap' => $categoryIdNameMap,
        ]);
    }

    public function create()
    {
        return view('pages.category.create-category', [
            'pageTitle' => 'Create category',
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
        ]);
    }

    public function createHandler(CategoryRequest $categoryRequest)
    {
        $categoryProperties = $categoryRequest->validated();
        $this->categoryService->createCategory($categoryProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    public function update($categoryId)
    {
        return view('pages.category.update-category', [
            'pageTitle' => 'Update category',
            'category' => $this->categoryService->findById($categoryId),
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
        ]);
    }

    public function updateHandler(CategoryRequest $categoryRequest, $categoryId)
    {
        $categoryProperties = $categoryRequest->validated();
        $this->categoryService->updateCategory($categoryProperties, $categoryId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    // TODO: validate here
    public function delete($categoryId)
    {
        $this->categoryService->deleteCategory($categoryId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }
}
