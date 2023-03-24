<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CustomerRequest;
use App\Services\CustomerAddressService;
use App\Services\CustomerService;
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
        $customers = $this->customerService->listCustomersPaginate(Constants::CUSTOMER_PAGE_COUNT);

        return view('pages.customer.list-customers', [
            'pageTitle' => 'List categories',
            'customers' => $customers,
        ]);
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

    public function showDetail($customerId) {
        $customer = $this->customerService->findById($customerId);
        $customerAddresses = $this->customerAddressService->findByCustomerId($customerId);

        return view('pages.customer.detail-customer', [
            'pageTitle' => 'Detail customer',
            'customer' => $customer,
            'customerAddresses' => $customerAddresses,
        ]);
    }
}