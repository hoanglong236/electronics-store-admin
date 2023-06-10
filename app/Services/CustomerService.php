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

    public function getCustomerById($customerId)
    {
        return $this->customerRepository->findById($customerId);
    }

    public function getListCustomersPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->customerRepository->searchAndPaginate('', $itemPerPage);
    }

    public function getSearchCustomersPaginator(
        $searchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $searchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return $this->customerRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }

    public function updateCustomerDisableFlag($customerDisableFlagProperties, $customerId)
    {
        $updateAttributes = [];
        $updateAttributes['disable_flag'] = $customerDisableFlagProperties['disableFlag'];
        $this->customerRepository->update($updateAttributes, $customerId);
    }

    public function deleteCustomerById($customerId)
    {
        $this->customerRepository->deleteById($customerId);
    }

    public function getCustomerAddressesByCustomerId($customerId)
    {
        return $this->customerRepository->retrieveCustomerAddressesByCustomerId($customerId);
    }
}
