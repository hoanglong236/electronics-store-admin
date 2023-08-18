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

    private function getBaseDataForCategoriesPage($paginator)
    {
        $data = [];
        $data['categories'] = $paginator->items();
        $data['paginator'] = $paginator;
        $data['categoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory(true);
        $data['pageTitle'] = 'Categories';

        return $data;
    }

    public function index()
    {
        $paginator = $this->categoryService->getCategoriesPaginator();

        $data = $this->getBaseDataForCategoriesPage($paginator);
        $data['searchKeyword'] = '';

        return view('pages.category.categories-page', ['data' => $data]);
    }

    public function search(SimpleSearchRequest $searchRequest)
    {
        $searchProps = $searchRequest->validated();
        $paginator = $this->categoryService->getSearchCategoriesPaginator($searchProps);
        $paginator = $paginator->withPath('search?' . CommonUtil::convertMapToParamsString($searchProps));

        $data = $this->getBaseDataForCategoriesPage($paginator);
        $data['searchKeyword'] = $searchProps['searchKeyword'];

        return view('pages.category.categories-page', ['data' => $data]);
    }

    public function create()
    {
        $data = [];
        $data['parentCategoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory();
        $data['pageTitle'] = 'Create category';

        return view('pages.category.category-create-page', ['data' => $data]);
    }

    public function createHandler(CategoryRequest $categoryRequest)
    {
        $categoryProps = $categoryRequest->validated();
        $this->categoryService->createCategory($categoryProps);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::CREATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    public function update(int $categoryId)
    {
        $category = $this->categoryService->getCategoryById($categoryId);
        $parentCategoryMap = $this->categoryService->getMapFromCategoryIdToCategory(!is_null($category->parent_id));
        unset($parentCategoryMap[$category->id]);

        $data = [];
        $data['category'] = $category;
        $data['parentCategoryMap'] = $parentCategoryMap;
        $data['pageTitle'] = 'Update category';

        return view('pages.category.category-update-page', ['data' => $data]);
    }

    public function updateHandler(CategoryRequest $categoryRequest, int $categoryId)
    {
        $categoryProps = $categoryRequest->validated();
        $this->categoryService->updateCategory($categoryProps, $categoryId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::UPDATE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }

    public function delete(int $categoryId)
    {
        $this->categoryService->deleteCategoryById($categoryId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::DELETE_SUCCESS);
        return redirect()->action([CategoryController::class, 'index']);
    }
}
