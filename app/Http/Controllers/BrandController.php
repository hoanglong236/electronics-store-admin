<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CreateBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
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
        return view('pages.brand.list-brands', ['pageTitle' => 'List brands', 'brands' => $brands]);
    }

    public function create(Request $request)
    {
        return view('pages.brand.create-brand', ['pageTitle' => 'Create brand']);
    }

    public function createHandler(CreateBrandRequest $createBrandRequest)
    {
        $brandValidatedProperties = $createBrandRequest->validated();

        $logoUploaded = $createBrandRequest->file('logo');
        $brandValidatedProperties['logoPath'] = Storage::putFileAs(
            Constants::BRAND_LOGO_STORAGE_PATH,
            $logoUploaded,
            rand() . time() . '.' . $logoUploaded->getClientOriginalExtension()
        );
        $this->brandService->createBrand($brandValidatedProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::CREATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function update(Request $request, $brandId)
    {
        $brand = $this->brandService->findBrandById($brandId);
        return view('pages.brand.update-brand', ['pageTitle' => 'Update brand', 'brand' => $brand]);
    }

    public function updateHandler(UpdateBrandRequest $updateBrandRequest, $brandId)
    {
        $brandValidatedProperties = $updateBrandRequest->validated();
        if ($updateBrandRequest->hasFile('logo')) {
            $logoUploaded = $updateBrandRequest->file('logo');
            $brandValidatedProperties['logoPath'] = Storage::putFileAs(
                Constants::BRAND_LOGO_STORAGE_PATH,
                $logoUploaded,
                rand() . time() . '.' . $logoUploaded->getClientOriginalExtension()
            );
        }
        $this->brandService->updateBrand($brandValidatedProperties, $brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function delete(Request $request, $brandId)
    {
        $this->brandService->deleteBrand($brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }
}
