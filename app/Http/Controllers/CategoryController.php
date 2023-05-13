<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\DataFilterConstants\CategorySearchOptionConstants;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategorySearchRequest;
use App\Services\CategoryService;
use App\Services\UtilsService;
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
        $paginator = $this->categoryService->getListCategoriesPaginator();

        $data = $this->getCommonDataForCategoriesPage();
        $data['categories'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.category.categories-page', ['data' => $data]);
    }

    public function search(CategorySearchRequest $categorySearchRequest)
    {
        $categorySearchProperties = $categorySearchRequest->validated();
        $paginator = $this->categoryService->getSearchCategoriesPaginator($categorySearchProperties);

        $data = $this->getCommonDataForCategoriesPage();
        $data['searchKeyword'] = $categorySearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $categorySearchProperties['searchOption'];
        $data['categories'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . UtilsService::convertMapToParamsString($categorySearchProperties)
        );

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
        $categoryIdNameMap = $this->categoryService->getCategoryIdNameMap();
        $data = [
            'pageTitle' => 'Create category',
            'categoryIdNameMap' => $categoryIdNameMap,
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
        $category = $this->categoryService->getCategoryById($categoryId);
        $categoryIdNameMap = $this->categoryService->getCategoryIdNameMap();

        $data = [
            'pageTitle' => 'Update category',
            'category' => $category,
            'categoryIdNameMap' => $categoryIdNameMap,
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

    public function delete($categoryId)
    {
        $this->categoryService->deleteCategory($categoryId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }
}
