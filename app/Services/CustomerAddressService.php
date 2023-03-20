<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Log;

class CustomerAddressService
{
    public function findByCustomerId($customerId)
    {
        return CustomerAddress::where(['customer_id' => $customerId])->get();
    }
}
