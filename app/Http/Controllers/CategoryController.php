<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategorySearchRequest;
use App\ModelConstants\CategorySearchOptionConstants;
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

    public function index()
    {
        $data = $this->getCommonDataForCategoriesPage();
        $data['categories'] = $this->categoryService->listCategories();

        return view('pages.category.categories-page', ['data' => $data]);
    }

    public function search(CategorySearchRequest $categorySearchRequest)
    {
        $categorySearchProperties = $categorySearchRequest->validated();

        $data = $this->getCommonDataForCategoriesPage();
        $data['categories'] = $this->categoryService->searchCategories($categorySearchProperties);
        $data['searchKeyword'] = $categorySearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $categorySearchProperties['searchOption'];

        return view('pages.category.categories-page', ['data' => $data]);
    }

    private function getCommonDataForCategoriesPage()
    {
        $categoryIdNameMap = $this->categoryService->getCategoryIdNameMap();

        return [
            'pageTitle' => 'Categories',
            'categoryIdNameMap' => $categoryIdNameMap,
            'searchKeyword' => '',
            'searchOptions' => CategorySearchOptionConstants::toArray(),
            'currentSearchOption' => CategorySearchOptionConstants::SEARCH_ALL,
        ];
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'Create category',
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
        ];

        return view('pages.category.category-create-page', ['data' => $data]);
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
        $data = [
            'pageTitle' => 'Update category',
            'category' => $this->categoryService->findById($categoryId),
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
        ];

        return view('pages.category.category-update-page', ['data' => $data]);
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
