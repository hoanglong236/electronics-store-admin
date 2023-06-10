<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CustomerDisableFlagRequest;
use App\Http\Requests\SimpleSearchRequest;
use App\Services\CustomerService;
use App\Services\UtilsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $paginator = $this->customerService->getListCustomersPaginator();
        $data = [];

        $data['pageTitle'] = 'Customers';
        $data['searchKeyword'] = '';
        $data['customers'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    public function search(SimpleSearchRequest $searchRequest)
    {
        $searchProperties = $searchRequest->validated();
        $paginator = $this->customerService->getSearchCustomersPaginator($searchProperties);
        $data = [];

        $data['pageTitle'] = 'Customers';
        $data['searchKeyword'] = $searchProperties['searchKeyword'];
        $data['customers'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . UtilsService::convertMapToParamsString($searchProperties)
        );

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    public function updateDisableFlag(CustomerDisableFlagRequest $customerDisableFlagRequest, $customerId)
    {
        $customerDisableFlagProperties = $customerDisableFlagRequest->validated();
        $this->customerService->updateCustomerDisableFlag($customerDisableFlagProperties, $customerId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([CustomerController::class, 'index']);
    }

    public function delete($customerId)
    {
        $this->customerService->deleteCustomerById($customerId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([CustomerController::class, 'index']);
    }

    public function showDetails($customerId)
    {
        $data = [];

        $data['pageTitle'] = 'Customer details';
        $data['customerDetails'] = $this->customerService->getCustomerDetails($customerId);

        return view('pages.customer.customer-details-page', ['data' => $data]);
    }
}
