<?php

namespace App\Services;

use App\Constants\ConfigConstants;
use App\Repositories\ICustomerRepository;
use App\Utils\CommonUtil;

class CustomerService
{
    private $customerRepository;

    public function __construct(ICustomerRepository $iCustomerRepository)
    {
        $this->customerRepository = $iCustomerRepository;
    }

    public function getCustomersPaginator(int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->customerRepository->searchAndPaginate('', $itemPerPage);
    }

    public function getSearchCustomersPaginator(
        array $searchProps, int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $searchProps['searchKeyword'];
        $escapedKeyword = CommonUtil::escapeKeyword($searchKeyword);

        return $this->customerRepository->searchAndPaginate($escapedKeyword, $itemPerPage);
    }

    public function updateCustomerDisableFlag(array $customerDisableProps, int $customerId)
    {
        $updateAttributes = [];
        $updateAttributes['disable_flag'] = $customerDisableProps['disableFlag'];
        $this->customerRepository->update($updateAttributes, $customerId);
    }

    public function deleteCustomerById(int $customerId)
    {
        $this->customerRepository->deleteById($customerId);
    }

    public function getCustomerDetails(int $customerId)
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

        $addresses = $this->customerRepository->getCustomerAddressesByCustomerId($customerId);
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
