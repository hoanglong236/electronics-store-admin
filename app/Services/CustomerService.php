<?php

namespace App\Services;

use App\Common\Constants;
use App\Repositories\ICustomerRepository;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    private $customerRepository;

    public function __construct(ICustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function findById($customerId)
    {
        return $this->customerRepository->findById($customerId);
    }

    public function getListCustomersPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->customerRepository->paginate($itemPerPage);
    }

    public function updateCustomerDisableFlag($customerDisableFlagProperties, $customerId)
    {
        $updateAttributes = [];
        $updateAttributes['disable_flag'] = $customerDisableFlagProperties['disableFlag'];
        $this->customerRepository->update($updateAttributes, $customerId);
    }

    public function deleteCustomer($customerId)
    {
        $this->customerRepository->deleteById($customerId);
    }

    public function getSearchCustomersPaginator(
        $customerSearchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $customerSearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return $this->customerRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }

    public function getCustomerAddressesByCustomerId($customerId)
    {
        return $this->customerRepository->retrieveCustomerAddressesByCustomerId($customerId);
    }
}
