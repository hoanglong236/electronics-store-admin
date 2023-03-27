<?php

namespace App\Services;

use App\ModelConstants\CustomerSearchOptionConstants;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function findById($customerId)
    {
        return Customer::where(['id' => $customerId, 'delete_flag' => false])->first();
    }

    public function listCustomersPaginate($itemPerPage)
    {
        return Customer::where('delete_flag', false)->paginate($itemPerPage);
    }

    public function updateDisableFlagCustomer($customerProperties, $customerId)
    {
        $customer = $this->findById($customerId);
        $customer->disable_flag = $customerProperties['disableFlag'];

        $customer->save();
    }

    public function deleteCustomer($customerId)
    {
        $customer = $this->findById($customerId);
        $customer->delete_flag = true;

        $customer->save();
    }

    public function searchCustomersPaginate($customerSearchProperties, $itemPerPage)
    {
        $searchOption = $customerSearchProperties['searchOption'];
        $searchKeyword = $customerSearchProperties['searchKeyword'];

        switch ($searchOption) {
            case CustomerSearchOptionConstants::SEARCH_ALL:
                return $this->searchCustomersByAll($searchKeyword, $itemPerPage);
            case CustomerSearchOptionConstants::SEARCH_NAME:
                return $this->searchCustomersByName($searchKeyword, $itemPerPage);
            case CustomerSearchOptionConstants::SEARCH_EMAIL:
                return $this->searchCustomersByEmail($searchKeyword, $itemPerPage);
            case CustomerSearchOptionConstants::SEARCH_PHONE:
                return $this->searchCustomersByPhone($searchKeyword, $itemPerPage);
            default:
                return [];
        }
    }

    private function searchCustomersByAll($searchKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where(function ($query) use ($searchKeyword) {
                $query->where('name', 'LIKE', '%' . UtilsService::escapeKeyword($searchKeyword) . '%')
                    ->orWhere('email', 'LIKE', '%' . UtilsService::escapeKeyword($searchKeyword) . '%')
                    ->orWhere('phone', 'LIKE', '%' . UtilsService::escapeKeyword($searchKeyword) . '%');
            })
            ->paginate($itemPerPage);
    }

    private function searchCustomersByName($searchKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where('name', 'LIKE', '%' . UtilsService::escapeKeyword($searchKeyword) . '%')
            ->paginate($itemPerPage);
    }

    private function searchCustomersByEmail($searchKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where('email', 'LIKE', '%' . UtilsService::escapeKeyword($searchKeyword) . '%')
            ->paginate($itemPerPage);
    }

    private function searchCustomersByPhone($searchKeyword, $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where('phone', 'LIKE', '%' . UtilsService::escapeKeyword($searchKeyword) . '%')
            ->paginate($itemPerPage);
    }
}
