<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public function findById($customerId)
    {
        return Customer::where(['id' => $customerId, 'delete_flag' => false])->first();
    }

    public function listCustomers()
    {
        return Customer::where('delete_flag', false)->get();
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
}
