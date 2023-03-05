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
        $brands = $this->brandService->listBrands();
        $brandNameMap = [];
        foreach ($brands as $brand) {
            $brandNameMap[$brand->id] = $brand->name;
        }

        $categories = $this->categoryService->listCategories();
        $categoryNameMap = [];
        foreach ($categories as $category) {
            $categoryNameMap[$category->id] = $category->name;
        }

        $products = $this->productService->listProducts();

        return view('pages.product.list-products', [
            'pageTitle' => 'List products',
            'products' => $products,
            'categoryNameMap' => $categoryNameMap,
            'brandNameMap' => $brandNameMap,
        ]);
    }

    public function create(Request $request)
    {
        $brands = $this->brandService->listBrands();
        $brandNameMap = [];
        foreach ($brands as $brand) {
            $brandNameMap[$brand->id] = $brand->name;
        }

        $categories = $this->categoryService->listCategories();
        $categoryNameMap = [];
        foreach ($categories as $category) {
            $categoryNameMap[$category->id] = $category->name;
        }

        return view('pages.product.create-product', [
            'pageTitle' => 'Create product',
            'categoryNameMap' => $categoryNameMap,
            'brandNameMap' => $brandNameMap,
        ]);
    }

    public function createHandler(ProductRequest $productRequest)
    {
        $mainImagePath = $this->storageService->saveFile(
            $productRequest->file('mainImage'),
            Constants::PRODUCT_IMAGE_PATH
        );

        $productProperties = array(
            'categoryId' => $productRequest->post('categoryId'),
            'brandId' => $productRequest->post('brandId'),
            'name' => $productRequest->post('name'),
            'mainImagePath' => $mainImagePath
        );
        $this->productService->createProduct($productProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function update(Request $request, $productId)
    {
        $brands = $this->brandService->listBrands();
        $brandNameMap = [];
        foreach ($brands as $brand) {
            $brandNameMap[$brand->id] = $brand->name;
        }

        $categories = $this->categoryService->listCategories();
        $categoryNameMap = [];
        foreach ($categories as $category) {
            $categoryNameMap[$category->id] = $category->name;
        }

        $product = $this->productService->findProductById($productId);

        return view('pages.product.update-product', [
            'pageTitle' => 'Update product',
            'product' => $product,
            'categoryNameMap' => $categoryNameMap,
            'brandNameMap' => $brandNameMap
        ]);
    }

    public function updateHandler(ProductRequest $productRequest, $productId)
    {
        if ($productRequest->hasFile('mainImage')) {
            $productProperties['mainImagePath'] = $this->storageService->saveFile(
                $productRequest->file('mainImage'),
                Constants::PRODUCT_IMAGE_PATH
            );;
        }

        $productProperties['categoryId'] = $productRequest->post('categoryId');
        $productProperties['brandId'] = $productRequest->post('brandId');
        $productProperties['name'] = $productRequest->post('name');
        $this->productService->updateProduct($productProperties, $productId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }

    public function delete(Request $request, $productId)
    {
        $this->productService->deleteProduct($productId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([ProductController::class, 'index']);
    }
}
