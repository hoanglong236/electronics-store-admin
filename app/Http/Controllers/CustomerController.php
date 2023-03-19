<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    public function index() {
        return view('pages.customer.list-customers', [
            'pageTitle' => 'List categories',
            'customers' => $this->customerService->listCustomers(),
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
}
