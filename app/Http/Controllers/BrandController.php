<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\BrandRequest;
use App\Services\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    private $brandService;

    public function __construct()
    {
        $this->brandService = new BrandService();
    }

    public function index(Request $request)
    {
        $brands = $this->brandService->listBrands();
        return view('pages.brand.list-brands', [
            'pageTitle' => 'List brands',
            'brands' => $brands
        ]);
    }

    public function create(Request $request)
    {
        return view('pages.brand.create-brand', ['pageTitle' => 'Create brand']);
    }

    public function createHandler(BrandRequest $brandRequest)
    {
        $logoUploaded = $brandRequest->file('logo');
        $logoStorageName = rand() . time() . '.' . $logoUploaded->getClientOriginalExtension();
        $logoPath = Storage::putFileAs(
            Constants::BRAND_LOGO_STORAGE_PATH, $logoUploaded, $logoStorageName
        );

        $brandProperties = array(
            'name' => $brandRequest->post('name'),
            'logoPath' => $logoPath
        );
        $this->brandService->createBrand($brandProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function update(Request $request, $brandId)
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
            $logoUploaded = $brandRequest->file('logo');
            $logoStorageName = rand() . time() . '.' . $logoUploaded->getClientOriginalExtension();
            $logoPath = Storage::putFileAs(
                Constants::BRAND_LOGO_STORAGE_PATH, $logoUploaded, $logoStorageName
            );

            $brandProperties['logoPath'] = $logoPath;
        }

        $brandProperties['name'] = $brandRequest->post('name');
        $this->brandService->updateBrand($brandProperties, $brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    // TODO: validate here
    public function delete(Request $request, $brandId)
    {
        $this->brandService->deleteBrand($brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }
}
