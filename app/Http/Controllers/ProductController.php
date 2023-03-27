<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductSearchRequest;
use App\ModelConstants\ProductSearchOptionConstants;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductImageService;
use App\Services\ProductService;
use App\Services\UtilsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    private $brandService;
    private $productImageService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
        $this->productImageService = new ProductImageService();
    }

    public function index()
    {
        $data = $this->getCommonDataForProductsPage();
        $data['products'] = $this->productService->listProductsPaginate(Constants::PRODUCT_PAGE_COUNT);

        return view('pages.product.products-page', ['data' => $data]);
    }

    public function search(ProductSearchRequest $productSearchRequest)
    {
        $productSearchProperties = $productSearchRequest->validated();

        $data = $this->getCommonDataForProductsPage();
        $data['products'] = $this->productService->searchProductsPaginate(
            $productSearchProperties,
            Constants::PRODUCT_PAGE_COUNT
        );
        $data['products']->withPath('search?' . UtilsService::convertMapToParamsString($productSearchProperties));
        $data['searchKeyword'] = $productSearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $productSearchProperties['searchOption'];

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
        $data = [
            'pageTitle' => 'Create product',
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
            'brandIdNameMap' => $this->brandService->getBrandIdNameMap(),
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
        $data = [
            'pageTitle' => 'Update product',
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
            'brandIdNameMap' => $this->brandService->getBrandIdNameMap(),
            'product' => $this->productService->findProductById($productId),
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
        $data = [
            'pageTitle' => 'Product details',
            'customProduct' => $this->productService->getCustomProductById($productId),
            'productImages' => $this->productImageService->listProductImagesInProduct($productId),
        ];

        return view('pages.product.product-details-page', ['data' => $data]);
    }

    public function createImages(ProductImageRequest $productImageRequest, $productId)
    {
        $productImageProperties = $productImageRequest->validated();
        $productImageProperties['productId'] = $productId;
        $this->productImageService->createProductImages($productImageProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetails'], $productId);
    }

    public function deleteImage($productId, $productImageId)
    {
        $this->productImageService->deleteProductImage($productImageId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetails'], $productId);
    }
}
