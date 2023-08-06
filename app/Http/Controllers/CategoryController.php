<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstants;
use App\Constants\MessageConstants;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SimpleSearchRequest;
use App\Services\CategoryService;
use App\Utils\CommonUtil;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    private function getCommonDataForCategoriesPage()
    {
        $data = [];
        $data['pageTitle'] = 'Categories';
        $data['categoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory(true);
        $data['searchKeyword'] = '';

        return $data;
    }

    public function index()
    {
        $paginator = $this->categoryService->getCategoriesPaginator();

        $data = $this->getCommonDataForCategoriesPage();
        $data['categories'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.category.categories-page', ['data' => $data]);
    }

    public function search(SimpleSearchRequest $searchRequest)
    {
        $searchProperties = $searchRequest->validated();
        $paginator = $this->categoryService->getSearchCategoriesPaginator($searchProperties);

        $data = $this->getCommonDataForCategoriesPage();
        $data['searchKeyword'] = $searchProperties['searchKeyword'];
        $data['categories'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . CommonUtil::convertMapToParamsString($searchProperties)
        );

        return view('pages.category.categories-page', ['data' => $data]);
    }

    public function create()
    {
        $data = [];
        $data['pageTitle'] = 'Create category';
        $data['parentCategoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory();

        return view('pages.category.category-create-page', ['data' => $data]);
    }

    public function createHandler(CategoryRequest $categoryRequest)
    {
        $categoryProperties = $categoryRequest->validated();
        $this->categoryService->createCategory($categoryProperties);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::CREATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    public function update($categoryId)
    {
        $category = $this->categoryService->getCategoryById($categoryId);
        $parentCategoryMap = $this->categoryService->getMapFromCategoryIdToCategory(!is_null($category->parent_id));
        unset($parentCategoryMap[$category->id]);

        $data = [];
        $data['pageTitle'] = 'Update category';
        $data['category'] = $category;
        $data['parentCategoryMap'] = $parentCategoryMap;

        return view('pages.category.category-update-page', ['data' => $data]);
    }

    public function updateHandler(CategoryRequest $categoryRequest, $categoryId)
    {
        $categoryProperties = $categoryRequest->validated();
        $this->categoryService->updateCategory($categoryProperties, $categoryId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::UPDATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    public function delete($categoryId)
    {
        $this->categoryService->deleteCategoryById($categoryId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::DELETE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }
}
