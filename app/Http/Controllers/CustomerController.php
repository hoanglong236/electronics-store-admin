<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstants;
use App\Constants\MessageConstants;
use App\Http\Requests\CustomerDisableRequest;
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

    private function getBaseDataForCustomersPage($paginator)
    {
        $data = [];
        $data['customers'] = $paginator->items();
        $data['paginator'] = $paginator;
        $data['pageTitle'] = 'Customers';

        return $data;
    }

    public function index()
    {
        $paginator = $this->customerService->getCustomersPaginator();

        $data = $this->getBaseDataForCustomersPage($paginator);
        $data['searchKeyword'] = '';

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    public function search(SimpleSearchRequest $searchRequest)
    {
        $searchProps = $searchRequest->validated();
        $paginator = $this->customerService->getSearchCustomersPaginator($searchProps);
        $paginator = $paginator->withPath('search?' . CommonUtil::convertMapToParamsString($searchProps));

        $data = $this->getBaseDataForCustomersPage($paginator);
        $data['searchKeyword'] = $searchProps['searchKeyword'];

        return view('pages.customer.customers-page', ['data' => $data]);
    }

    public function updateDisableFlag(CustomerDisableRequest $customerDisableRequest, int $customerId)
    {
        $customerDisableProps = $customerDisableRequest->validated();
        $this->customerService->updateCustomerDisableFlag($customerDisableProps, $customerId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::UPDATE_SUCCESS);
        return redirect()->action([CustomerController::class, 'index']);
    }

    public function delete(int $customerId)
    {
        $this->customerService->deleteCustomerById($customerId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::DELETE_SUCCESS);
        return redirect()->action([CustomerController::class, 'index']);
    }

    public function showDetails(int $customerId)
    {
        $data = [];
        $data['customerDetails'] = $this->customerService->getCustomerDetails($customerId);
        $data['pageTitle'] = 'Customer details';

        return view('pages.customer.customer-details-page', ['data' => $data]);
    }
}
