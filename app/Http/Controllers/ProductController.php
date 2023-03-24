<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductImageService;
use App\Services\ProductService;
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
        $products = $this->productService->listProductsPaginate(Constants::PRODUCT_PAGE_COUNT);

        return view('pages.product.products-page', [
            'pageTitle' => 'List products',
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('pages.product.product-create-page', [
            'pageTitle' => 'Create product',
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
            'brandIdNameMap' => $this->brandService->getBrandIdNameMap(),
        ]);
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
        $product = $this->productService->findProductById($productId);

        return view('pages.product.product-update-page', [
            'pageTitle' => 'Update product',
            'product' => $product,
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
            'brandIdNameMap' => $this->brandService->getBrandIdNameMap(),
        ]);
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

    public function showDetails($productId) {
        $product = $this->productService->findProductById($productId);

        return view('pages.product.product-details-page', [
            'pageTitle' => 'Product details',
            'product' => $product,
            'categoryIdNameMap' => $this->categoryService->getCategoryIdNameMap(),
            'brandIdNameMap' => $this->brandService->getBrandIdNameMap(),
            'productImages' => $this->productImageService->listProductImagesInProduct($productId),
        ]);
    }

    public function createImages(ProductImageRequest $productImageRequest, $productId) {
        $productImageProperties = $productImageRequest->validated();
        $productImageProperties['productId'] = $productId;
        $this->productImageService->createProductImages($productImageProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetail'], $productId);
    }

    public function deleteImage(Request $request, $productId, $productImageId) {
        $this->productImageService->deleteProductImage($productImageId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'showDetail'], $productId);
    }
}
