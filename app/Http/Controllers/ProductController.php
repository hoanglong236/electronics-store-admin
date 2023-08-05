<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\Constants\ProductSearchRequestConstants;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Utils\CommonUtil;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    private $brandService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        BrandService $brandService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }

    public function index()
    {
        $paginator = $this->productService->getProductsPaginator();

        $data = $this->getCommonDataForProductsPage();
        $data['products'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.product.products-page', ['data' => $data]);
    }

    public function search(ProductSearchRequest $productSearchRequest)
    {
        $productSearchProperties = $productSearchRequest->validated();
        $paginator = $this->productService->getSearchProductsPaginator($productSearchProperties);

        $data = $this->getCommonDataForProductsPage();
        $data['searchKeyword'] = $productSearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $productSearchProperties['searchOption'];
        $data['products'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . CommonUtil::convertMapToParamsString($productSearchProperties)
        );

        return view('pages.product.products-page', ['data' => $data]);
    }

    private function getCommonDataForProductsPage()
    {
        return [
            'pageTitle' => 'Products',
            'searchKeyword' => '',
            'searchOptions' => ProductSearchRequestConstants::toArray(),
            'currentSearchOption' => ProductSearchRequestConstants::SEARCH_ALL,
        ];
    }

    public function create()
    {
        $data = [];

        $data['pageTitle'] = 'Create product';
        $data['categoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory();
        $data['brandMap'] = $this->brandService->getMapFromBrandIdToBrand();

        return view('pages.product.product-create-page', ['data' => $data]);
    }

    public function createHandler(ProductRequest $productRequest)
    {
        $productProperties = $productRequest->validated();
        $this->productService->createProduct($productProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function update($productId)
    {
        $data = [];

        $data['pageTitle'] = 'Update product';
        $data['categoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory(true);
        $data['brandMap'] = $this->brandService->getMapFromBrandIdToBrand(true);
        $data['product'] = $this->productService->getProductById($productId);

        return view('pages.product.product-update-page', ['data' => $data]);
    }

    public function updateHandler(ProductRequest $productRequest, $productId)
    {
        $productProperties = $productRequest->validated();
        $this->productService->updateProduct($productProperties, $productId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function delete($productId)
    {
        $this->productService->deleteProductById($productId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function showDetails($productId)
    {
        $data = [];

        $data['pageTitle'] = 'Product details';
        $data['productDetails'] = $this->productService->getProductDetails($productId);

        return view('pages.product.product-details-page', ['data' => $data]);
    }

    public function createImages(ProductImageRequest $productImageRequest, $productId)
    {
        $productImageProperties = $productImageRequest->validated();
        $productImageProperties['productId'] = $productId;
        $this->productService->createProductImages($productImageProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetails'], $productId);
    }

    public function deleteImage($productId, $productImageId)
    {
        $this->productService->deleteProductImageById($productImageId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetails'], $productId);
    }
}
