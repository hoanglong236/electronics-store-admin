<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\ProductRequest;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    private $brandService;
    private $storageService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
        $this->storageService = new StorageService();
    }

    public function index()
    {
        $products = $this->productService->listProductsPaginate(Constants::PRODUCT_PAGE_COUNT);

        return view('pages.product.list-products', [
            'pageTitle' => 'List products',
            'products' => $products,
            'categoryNameMap' => $this->categoryService->getCategoryNameMap(),
            'brandNameMap' => $this->brandService->getBrandNameMap(),
        ]);
    }

    public function create()
    {
        return view('pages.product.create-product', [
            'pageTitle' => 'Create product',
            'categoryNameMap' => $this->categoryService->getCategoryNameMap(),
            'brandNameMap' => $this->brandService->getBrandNameMap(),
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

        return view('pages.product.update-product', [
            'pageTitle' => 'Update product',
            'product' => $product,
            'categoryNameMap' => $this->categoryService->getCategoryNameMap(),
            'brandNameMap' => $this->brandService->getBrandNameMap(),
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
}
