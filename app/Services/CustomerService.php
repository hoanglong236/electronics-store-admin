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

    public function getCustomersPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
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

    public function getCustomerDetails($customerId)
    {
        $customerDetails = [];

        $customer = $this->customerRepository->findById($customerId);
        $customerDetails['customerInfo'] = [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'disableFlag' => $customer->disable_flag,
            'createdAt' => $customer->created_at,
            'updatedAt' => $customer->updated_at,
        ];

        $addresses = $this->customerRepository->retrieveCustomerAddressesByCustomerId($customerId);
        foreach ($addresses as $address) {
            $customerDetails['addresses'][] = [
                'specificAddress' => $address->specific_address,
                'ward' => $address->ward,
                'district' => $address->district,
                'city' => $address->city,
                'addressType' => $address->address_type,
                'defaultFlag' => $address->default_flag,
            ];
        }

        return $customerDetails;
    }
}
