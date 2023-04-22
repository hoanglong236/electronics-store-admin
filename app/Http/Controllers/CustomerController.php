<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\DataFilterConstants\CustomerSearchOptionConstants;
use App\Http\Requests\CustomerDisableFlagRequest;
use App\Http\Requests\CustomerSearchRequest;
use App\Services\CustomerService;
use App\Services\UtilsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    public function index()
    {
        $customerPaginator = $this->customerService->getCustomerPaginator(Constants::CUSTOMER_PAGE_COUNT);

        $data = $this->getCommonDataForCustomersPage();
        $data['customers'] = $customerPaginator->items();
        $data['customerPaginator'] = $customerPaginator;

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    public function search(CustomerSearchRequest $customerSearchRequest)
    {
        $customerSearchProperties = $customerSearchRequest->validated();
        $searchCustomerPaginator = $this->customerService->getSearchCustomerPaginator(
            $customerSearchProperties,
            Constants::CUSTOMER_PAGE_COUNT
        );

        $data = $this->getCommonDataForCustomersPage();
        $data['customers'] = $searchCustomerPaginator->items();
        $data['customerPaginator'] = $searchCustomerPaginator->withPath(
            'search?' . UtilsService::convertMapToParamsString($customerSearchProperties)
        );
        $data['searchKeyword'] = $customerSearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $customerSearchProperties['searchOption'];

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    private function getCommonDataForCustomersPage()
    {
        return [
            'pageTitle' => 'Customers',
            'searchKeyword' => '',
            'searchOptions' => CustomerSearchOptionConstants::toArray(),
            'currentSearchOption' => CustomerSearchOptionConstants::SEARCH_ALL,
        ];
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
        $this->customerService->deleteCustomer($customerId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::DELETE_SUCCESS);
        return redirect()->action([CustomerController::class, 'index']);
    }

    public function showDetails($customerId)
    {
        $customer = $this->customerService->getCustomerById($customerId);
        $customerAddresses = $this->customerService->getCustomerAddressesByCustomerId($customerId);

        $data = [
            'pageTitle' => 'Customer details',
            'customer' => $customer,
            'customerAddresses' => $customerAddresses,
        ];

        return view('pages.customer.customer-details-page', ['data' => $data]);
    }
}
