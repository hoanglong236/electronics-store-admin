<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\BrandRequest;
use App\Services\BrandService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    private $brandService;

    public function __construct()
    {
        $this->brandService = new BrandService();
    }

    public function index()
    {
        $brands = $this->brandService->listBrands();

        return view('pages.brand.brands', [
            'pageTitle' => 'List brands',
            'brands' => $brands
        ]);
    }

    public function create()
    {
        return view('pages.brand.brand-create', ['pageTitle' => 'Create brand']);
    }

    public function createHandler(BrandRequest $brandRequest)
    {
        $brandProperties = $brandRequest->validated();
        $this->brandService->createBrand($brandProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function update($brandId)
    {
        $brand = $this->brandService->findById($brandId);

        return view('pages.brand.brand-update', [
            'pageTitle' => 'Update brand',
            'brand' => $brand
        ]);
    }

    public function updateHandler(BrandRequest $brandRequest, $brandId)
    {
        $brandProperties = $brandRequest->validated();
        $this->brandService->updateBrand($brandProperties, $brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    // TODO: validate here
    public function delete($brandId)
    {
        $this->brandService->deleteBrand($brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }
}
