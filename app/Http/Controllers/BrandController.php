<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstants;
use App\Constants\MessageConstants;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\SimpleSearchRequest;
use App\Services\BrandService;
use App\Utils\CommonUtil;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    private function getBaseDataForBrandsPage($paginator)
    {
        $data = [];
        $data['brands'] = $paginator->items();
        $data['paginator'] = $paginator;
        $data['pageTitle'] = 'Brands';

        return $data;
    }

    public function index()
    {
        $paginator = $this->brandService->getBrandsPaginator();

        $data = $this->getBaseDataForBrandsPage($paginator);
        $data['searchKeyword'] = '';

        return view('pages.brand.brands-page', ['data' => $data]);
    }

    public function search(SimpleSearchRequest $searchRequest)
    {
        $searchProps = $searchRequest->validated();
        $paginator = $this->brandService->getSearchBrandsPaginator($searchProps);
        $paginator = $paginator->withPath('search?' . CommonUtil::convertMapToParamsString($searchProps));

        $data = $this->getBaseDataForBrandsPage($paginator);
        $data['searchKeyword'] = $searchProps['searchKeyword'];

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
        $brandProps = $brandRequest->validated();
        $this->brandService->createBrand($brandProps);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::CREATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function update(int $brandId)
    {
        $data = [];
        $data['brand'] = $this->brandService->getBrandById($brandId);
        $data['pageTitle'] = 'Update Brand';

        return view('pages.brand.brand-update-page', ['data' => $data]);
    }

    public function updateHandler(BrandRequest $brandRequest, int $brandId)
    {
        $brandProps = $brandRequest->validated();
        $this->brandService->updateBrand($brandProps, $brandId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::UPDATE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }

    public function delete(int $brandId)
    {
        $this->brandService->deleteBrandById($brandId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::DELETE_SUCCESS);
        return redirect()->action([BrandController::class, 'index']);
    }
}
