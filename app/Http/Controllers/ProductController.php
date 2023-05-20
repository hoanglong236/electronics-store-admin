<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\DataFilterConstants\ProductSearchOptionConstants;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductSearchRequest;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UtilsService;
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
    )
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }

    public function index()
    {
        $paginator = $this->productService->getCustomProductsPaginator();

        $data = $this->getCommonDataForProductsPage();
        $data['products'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.product.products-page', ['data' => $data]);
    }

    public function search(ProductSearchRequest $productSearchRequest)
    {
        $productSearchProperties = $productSearchRequest->validated();
        $paginator = $this->productService->getSearchCustomProductsPaginator($productSearchProperties);

        $data = $this->getCommonDataForProductsPage();
        $data['searchKeyword'] = $productSearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $productSearchProperties['searchOption'];
        $data['products'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . UtilsService::convertMapToParamsString($productSearchProperties)
        );

        return view('pages.product.products-page', ['data' => $data]);
    }

    private function getCommonDataForProductsPage()
    {
        return [
            'pageTitle' => 'Products',
            'searchKeyword' => '',
            'searchOptions' => ProductSearchOptionConstants::toArray(),
            'currentSearchOption' => ProductSearchOptionConstants::SEARCH_ALL,
        ];
    }

    public function create()
    {
        $categoryIdNameMap = $this->categoryService->getCategoryIdNameMap();
        $brandIdNameMap = $this->brandService->getBrandIdNameMap();

        $data = [
            'pageTitle' => 'Create product',
            'categoryIdNameMap' => $categoryIdNameMap,
            'brandIdNameMap' => $brandIdNameMap,
        ];

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
        $categoryIdNameMap = $this->categoryService->getCategoryIdNameMap();
        $brandIdNameMap = $this->brandService->getBrandIdNameMap();
        $product = $this->productService->findById($productId);

        $data = [
            'pageTitle' => 'Update product',
            'categoryIdNameMap' => $categoryIdNameMap,
            'brandIdNameMap' => $brandIdNameMap,
            'product' => $product,
        ];

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
        $this->productService->deleteProduct($productId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function showDetails($productId)
    {
        $customProduct = $this->productService->getCustomProductById($productId);
        $productImages = $this->productService->getProductImagesByProductId($productId);

        $data = [
            'pageTitle' => 'Product details',
            'product' => $customProduct,
            'productImages' => $productImages,
        ];

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
        $this->productService->deleteProductImage($productImageId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetails'], $productId);
    }
}
