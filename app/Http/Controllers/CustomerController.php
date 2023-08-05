<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstants;
use App\Constants\MessageConstants;
use App\Http\Requests\CustomerDisableFlagRequest;
use App\Http\Requests\SimpleSearchRequest;
use App\Services\CustomerService;
use App\Utils\CommonUtil;
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
        $paginator = $this->customerService->getCustomersPaginator();
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
            'search?' . CommonUtil::convertMapToParamsString($searchProperties)
        );

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    public function updateDisableFlag(CustomerDisableFlagRequest $customerDisableFlagRequest, $customerId)
    {
        $customerDisableFlagProperties = $customerDisableFlagRequest->validated();
        $this->customerService->updateCustomerDisableFlag($customerDisableFlagProperties, $customerId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::UPDATE_SUCCESS);
        return redirect()->action([CustomerController::class, 'index']);
    }

    public function delete($customerId)
    {
        $this->customerService->deleteCustomerById($customerId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::DELETE_SUCCESS);
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
