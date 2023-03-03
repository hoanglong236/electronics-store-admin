<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\ProductRequest;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $productService;
    private $categoryService;
    private $brandService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
        $this->brandService = new BrandService();
    }

    public function index() {
        return view('pages.product.list-products', [
            'pageTitle' => 'List products',
            'products' => $this->productService->listProducts(),
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.product.create-product', [
            'pageTitle' => 'Create product',
            'categories' => $this->categoryService->listCategories(),
            'brands' => $this->brandService->listBrands()
        ]);
    }

    public function createHandler(ProductRequest $productRequest)
    {
        $mainImageUploaded = $productRequest->file('mainImage');
        $mainImageStorageName = rand() . time() . '.' . $mainImageUploaded->getClientOriginalExtension();
        $mainImagePath = Storage::putFileAs(
            Constants::PRODUCT_IMAGE_PATH, $mainImageUploaded, $mainImageStorageName
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
        return view('pages.product.update-product', [
            'pageTitle' => 'Update product',
            'product' => $this->productService->findProductById($productId),
            'categories' => $this->categoryService->listCategories(),
            'brands' => $this->brandService->listBrands()
        ]);
    }

    public function updateHandler(ProductRequest $productRequest, $productId)
    {
        if ($productRequest->hasFile('mainImage')) {
            $mainImageUploaded = $productRequest->file('mainImage');
            $mainImageStorageName = rand() . time() . '.' . $mainImageUploaded->getClientOriginalExtension();
            $mainImagePath = Storage::putFileAs(
                Constants::PRODUCT_IMAGE_PATH, $mainImageUploaded, $mainImageStorageName
            );

            $productProperties['mainImagePath'] = $mainImagePath;
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
