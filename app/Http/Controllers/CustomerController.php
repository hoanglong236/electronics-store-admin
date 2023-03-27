<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\CustomerSearchRequest;
use App\ModelConstants\CustomerSearchOptionConstants;
use App\Services\CustomerAddressService;
use App\Services\CustomerService;
use App\Services\UtilsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private $customerService;
    private $customerAddressService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
        $this->customerAddressService = new CustomerAddressService();
    }

    public function index()
    {
        $data = $this->getCommonDataForCustomersPage();
        $data['customers'] = $this->customerService->listCustomersPaginate(Constants::CUSTOMER_PAGE_COUNT);

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    public function search(CustomerSearchRequest $customerSearchRequest)
    {
        $customerSearchProperties = $customerSearchRequest->validated();

        $data = $this->getCommonDataForCustomersPage();
        $data['customers'] = $this->customerService->searchCustomersPaginate(
            $customerSearchProperties,
            Constants::CUSTOMER_PAGE_COUNT
        );
        $data['customers']->withPath('search?' . UtilsService::convertMapToParamsString($customerSearchProperties));
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

    public function updateDisableFlag(CustomerRequest $customerRequest, $customerId)
    {
        $customerProperties = $customerRequest->validated();
        $this->customerService->updateDisableFlagCustomer($customerProperties, $customerId);

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
        $data = [
            'pageTitle' => 'Customer details',
            'customer' => $this->customerService->findById($customerId),
            'customerAddresses' => $this->customerAddressService->findByCustomerId($customerId),
        ];

        return view('pages.customer.customer-details-page', ['data' => $data]);
    }
}
