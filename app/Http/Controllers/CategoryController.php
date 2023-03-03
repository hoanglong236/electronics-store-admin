<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    public function index(Request $request)
    {
        return view('pages.category.list-categories', [
            'pageTitle' => 'List categories',
            'categories' => $this->categoryService->listCategories(),
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.category.create-category', [
            'pageTitle' => 'Create category',
            'categories' => $this->categoryService->listCategories(),
        ]);
    }

    public function createHandler(CategoryRequest $categoryRequest)
    {
        $parentCategoryId = $categoryRequest->post('parentId');
        $categoryProperties = array(
            'name' => $categoryRequest->post('name'),
            'parentId' => !isset($parentCategoryId) ? null : (int) $parentCategoryId
        );
        $this->categoryService->createCategory($categoryProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    public function update(Request $request, $categoryId)
    {
        return view('pages.category.update-category', [
            'pageTitle' => 'Update category',
            'category' => $this->categoryService->findCategoryById($categoryId),
            'categories' => $this->categoryService->listCategories(),
        ]);
    }

    public function updateHandler(CategoryRequest $categoryRequest, $categoryId)
    {
        $parentCategoryId = $categoryRequest->post('parentId');
        $categoryProperties = array(
            'name' => $categoryRequest->post('name'),
            'parentId' => !isset($parentCategoryId) ? null : (int) $parentCategoryId
        );
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
