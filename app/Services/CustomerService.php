<?php

namespace App\Services;

use App\DataFilterConstants\CustomerSearchOptionConstants;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function getCustomerById($customerId)
    {
        return Customer::where(['id' => $customerId, 'delete_flag' => false])->first();
    }

    public function listCustomersPaginate($itemPerPage)
    {
        return Customer::where('delete_flag', false)->paginate($itemPerPage);
    }

    public function updateDisableFlagCustomer($customerDisableFlagProperties, $customerId)
    {
        $customer = $this->getCustomerById($customerId);
        $customer->disable_flag = $customerDisableFlagProperties['disableFlag'];

        $customer->save();
    }

    public function deleteCustomer($customerId)
    {
        $customer = $this->getCustomerById($customerId);
        $customer->delete_flag = true;

        $customer->save();
    }

    public function searchCustomersPaginate($customerSearchProperties, $itemPerPage)
    {
        $searchOption = $customerSearchProperties['searchOption'];
        $searchKeyword = $customerSearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $queryBuilder = $this->getSearchCustomersQueryBuilder($escapedKeyword, $searchOption);
        if (is_null($queryBuilder)) {
            return [];
        }

        return $queryBuilder->paginate($itemPerPage);
    }

    private function getSearchCustomersQueryBuilder($escapedKeyword, $searchOption)
    {
        switch ($searchOption) {
            case CustomerSearchOptionConstants::SEARCH_ALL:
                return $this->getSearchCustomersByAllQueryBuilder($escapedKeyword);
            case CustomerSearchOptionConstants::SEARCH_NAME:
                return $this->getSearchCustomersByNameQueryBuilder($escapedKeyword);
            case CustomerSearchOptionConstants::SEARCH_EMAIL:
                return $this->getSearchCustomersByEmailQueryBuilder($escapedKeyword);
            case CustomerSearchOptionConstants::SEARCH_PHONE:
                return $this->getSearchCustomersByPhoneQueryBuilder($escapedKeyword);
            default:
                return null;
        }
    }

    private function getSearchCustomersByAllQueryBuilder($escapedKeyword)
    {
        return Customer::where('delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $escapedKeyword . '%');
            });
    }

    private function getSearchCustomersByNameQueryBuilder($escapedKeyword)
    {
        return Customer::where('delete_flag', false)
            ->where('name', 'LIKE', '%' . $escapedKeyword . '%');
    }

    private function getSearchCustomersByEmailQueryBuilder($escapedKeyword)
    {
        return Customer::where('delete_flag', false)
            ->where('email', 'LIKE', '%' . $escapedKeyword . '%');
    }

    private function getSearchCustomersByPhoneQueryBuilder($escapedKeyword)
    {
        return Customer::where('delete_flag', false)
            ->where('phone', 'LIKE', '%' . $escapedKeyword . '%');
    }

    public function getCustomerAddressesByCustomerId($customerId)
    {
        return CustomerAddress::where(['customer_id' => $customerId])->get();
    }
}
