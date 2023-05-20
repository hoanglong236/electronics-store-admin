<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\BrandSearchRequest;
use App\Services\BrandService;
use App\Services\UtilsService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $paginator = $this->brandService->getListBrandsPaginator();

        $data = $this->getCommonDataForBrandsPage();
        $data['brands'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.brand.brands-page', ['data' => $data]);
    }

    public function search(BrandSearchRequest $brandSearchRequest)
    {
        $searchBrandProperties = $brandSearchRequest->validated();
        $paginator = $this->brandService->getSearchBrandsPaginator($searchBrandProperties);

        $data = $this->getCommonDataForBrandsPage();
        $data['searchKeyword'] = $searchBrandProperties['searchKeyword'];
        $data['brands'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . UtilsService::convertMapToParamsString($searchBrandProperties)
        );

        return view('pages.brand.brands-page', ['data' => $data]);
    }

    private function getCommonDataForBrandsPage()
    {
        return [
            'pageTitle' => 'Brands',
            'searchKeyword' => '',
        ];
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'Create brand',
        ];

        return view('pages.brand.brand-create-page', ['data' => $data]);
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
        $data = [
            'pageTitle' => 'Update brand',
            'brand' => $this->brandService->findById($brandId),
        ];

        return view('pages.brand.brand-update-page', ['data' => $data]);
    }

    public function updateHandler(BrandRequest $brandRequest, $brandId)
    {
        $brandProperties = $brandRequest->validated();
        $this->brandService->updateBrand($brandProperties, $brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function delete($brandId)
    {
        $this->brandService->deleteBrand($brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }
}
