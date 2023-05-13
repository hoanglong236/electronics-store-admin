<?php

namespace App\Services;

use App\Common\Constants;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function getCustomerById($customerId)
    {
        return Customer::where(['id' => $customerId, 'delete_flag' => false])->first();
    }

    public function getListCustomersPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return Customer::where('delete_flag', false)
            ->latest()
            ->paginate($itemPerPage);
    }

    public function updateCustomerDisableFlag($customerDisableFlagProperties, $customerId)
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

    public function getSearchCustomersPaginator(
        $customerSearchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $customerSearchProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return Customer::where('delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }

    public function getCustomerAddressesByCustomerId($customerId)
    {
        return CustomerAddress::where(['customer_id' => $customerId])->get();
    }
}
