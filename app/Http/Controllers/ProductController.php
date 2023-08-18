<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstants;
use App\Constants\MessageConstants;
use App\Http\Requests\Constants\ProductSearchRequestConstants;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Utils\CommonUtil;
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

    private function getBaseDataForProductsPage($paginator)
    {
        $data = [];
        $data['products'] = $paginator->items();
        $data['paginator'] = $paginator;
        $data['searchOptions'] = ProductSearchRequestConstants::toArray();
        $data['pageTitle'] = 'Products';

        return $data;
    }

    public function index()
    {
        $paginator = $this->productService->getProductsPaginator();

        $data = $this->getBaseDataForProductsPage($paginator);
        $data['searchKeyword'] = '';
        $data['currentSearchOption'] = ProductSearchRequestConstants::SEARCH_ALL;

        return view('pages.product.products-page', ['data' => $data]);
    }

    public function search(ProductSearchRequest $productSearchRequest)
    {
        $productSearchProps = $productSearchRequest->validated();
        $paginator = $this->productService->getSearchProductsPaginator($productSearchProps);
        $paginator = $paginator->withPath('search?' . CommonUtil::convertMapToParamsString($productSearchProps));

        $data = $this->getBaseDataForProductsPage($paginator);
        $data['searchKeyword'] = $productSearchProps['searchKeyword'];
        $data['currentSearchOption'] = $productSearchProps['searchOption'];

        return view('pages.product.products-page', ['data' => $data]);
    }

    public function create()
    {
        $data = [];
        $data['categoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory();
        $data['brandMap'] = $this->brandService->getMapFromBrandIdToBrand();
        $data['pageTitle'] = 'Create product';

        return view('pages.product.product-create-page', ['data' => $data]);
    }

    public function createHandler(ProductRequest $productRequest)
    {
        $productProps = $productRequest->validated();
        $this->productService->createProduct($productProps);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::CREATE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function update(int $productId)
    {
        $data = [];
        $data['categoryMap'] = $this->categoryService->getMapFromCategoryIdToCategory(true);
        $data['brandMap'] = $this->brandService->getMapFromBrandIdToBrand(true);
        $data['product'] = $this->productService->getProductById($productId);
        $data['pageTitle'] = 'Update product';

        return view('pages.product.product-update-page', ['data' => $data]);
    }

    public function updateHandler(ProductRequest $productRequest, int $productId)
    {
        $productProps = $productRequest->validated();
        $this->productService->updateProduct($productProps, $productId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::UPDATE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function delete(int $productId)
    {
        $this->productService->deleteProductById($productId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function showDetails(int $productId)
    {
        $data = [];
        $data['productDetails'] = $this->productService->getProductDetails($productId);
        $data['pageTitle'] = 'Product details';

        return view('pages.product.product-details-page', ['data' => $data]);
    }

    public function createImages(ProductImageRequest $productImageRequest, int $productId)
    {
        $productImageProps = $productImageRequest->validated();
        $productImageProps['productId'] = $productId;
        $this->productService->createProductImages($productImageProps);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::CREATE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetails'], $productId);
    }

    public function deleteImage(int $productId, int $productImageId)
    {
        $this->productService->deleteProductImageById($productImageId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetails'], $productId);
    }
}
