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

    public function updateDisableFlagCustomer($customerProperties, $customerId)
    {
        $customer = $this->getCustomerById($customerId);
        $customer->disable_flag = $customerProperties['disableFlag'];

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

        switch ($searchOption) {
            case CustomerSearchOptionConstants::SEARCH_ALL:
                return $this->searchCustomersByAll($escapedKeyword, $itemPerPage);
            case CustomerSearchOptionConstants::SEARCH_NAME:
                return $this->searchCustomersByName($escapedKeyword, $itemPerPage);
            case CustomerSearchOptionConstants::SEARCH_EMAIL:
                return $this->searchCustomersByEmail($escapedKeyword, $itemPerPage);
            case CustomerSearchOptionConstants::SEARCH_PHONE:
                return $this->searchCustomersByPhone($escapedKeyword, $itemPerPage);
            default:
                return [];
        }
    }

    private function searchCustomersByAll($escapedKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->paginate($itemPerPage);
    }

    private function searchCustomersByName($escapedKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where('name', 'LIKE', '%' . $escapedKeyword . '%')
            ->paginate($itemPerPage);
    }

    private function searchCustomersByEmail($escapedKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where('email', 'LIKE', '%' . $escapedKeyword . '%')
            ->paginate($itemPerPage);
    }

    private function searchCustomersByPhone($escapedKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where('phone', 'LIKE', '%' . $escapedKeyword . '%')
            ->paginate($itemPerPage);
    }

    public function getCustomerAddressesByCustomerId($customerId)
    {
        return CustomerAddress::where(['customer_id' => $customerId])->get();
    }
}
