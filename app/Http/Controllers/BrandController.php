<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\BrandRequest;
use App\Services\BrandService;
use App\Services\StorageService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    private $brandService;
    private $storageService;

    public function __construct()
    {
        $this->brandService = new BrandService();
        $this->storageService = new StorageService();
    }

    public function index()
    {
        $brands = $this->brandService->listBrands();
        return view('pages.brand.list-brands', [
            'pageTitle' => 'List brands',
            'brands' => $brands
        ]);
    }

    public function create()
    {
        return view('pages.brand.create-brand', ['pageTitle' => 'Create brand']);
    }

    public function createHandler(BrandRequest $brandRequest)
    {
        $brandProperties = array(
            'name' => $brandRequest->post('name'),
            'logoPath' => $this->storageService->saveFile(
                $brandRequest->file('logo'),
                Constants::BRAND_LOGO_STORAGE_PATH
            ),
        );
        $this->brandService->createBrand($brandProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function update($brandId)
    {
        $brand = $this->brandService->findBrandById($brandId);
        return view('pages.brand.update-brand', [
            'pageTitle' => 'Update brand',
            'brand' => $brand
        ]);
    }

    public function updateHandler(BrandRequest $brandRequest, $brandId)
    {
        if ($brandRequest->hasFile('logo')) {
            $brandProperties['logoPath'] = $this->storageService->saveFile(
                $brandRequest->file('logo'),
                Constants::BRAND_LOGO_STORAGE_PATH
            );
        }
        $brandProperties['name'] = $brandRequest->post('name');
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

    // TODO: handle only delete brand logo
}
