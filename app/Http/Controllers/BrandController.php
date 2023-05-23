<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\SimpleSearchRequest;
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
        $data = [];

        $data['pageTitle'] = 'Brands';
        $data['searchKeyword'] = '';
        $data['brands'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.brand.brands-page', ['data' => $data]);
    }

    public function search(SimpleSearchRequest $searchRequest)
    {
        $searchProperties = $searchRequest->validated();
        $paginator = $this->brandService->getSearchBrandsPaginator($searchProperties);
        $data = [];

        $data['pageTitle'] = 'Brands';
        $data['searchKeyword'] = $searchProperties['searchKeyword'];
        $data['brands'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . UtilsService::convertMapToParamsString($searchProperties)
        );

        return view('pages.brand.brands-page', ['data' => $data]);
    }

    public function create()
    {
        $data = [];
        $data['pageTitle'] = 'Create brand';
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
        $data = [];

        $data['pageTitle'] = 'Update Brand';
        $data['brand'] = $this->brandService->getBrandById($brandId);

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
        $this->brandService->deleteBrandById($brandId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }
}
