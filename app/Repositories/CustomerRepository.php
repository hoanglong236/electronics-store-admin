<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerAddress;

class CustomerRepository implements ICustomerRepository
{
    public function findById(int $id)
    {
        return Customer::where(['id' => $id, 'delete_flag' => false])
            ->first();
    }

    public function update(array $attributes, int $id)
    {
        $customer = $this->findById($id);
        if ($customer) {
            $customer->update($attributes);
            return $customer;
        }
        return false;
    }

    public function deleteById(int $id)
    {
        $customer = $this->findById($id);
        if ($customer) {
            $customer->update(['delete_flag' => true]);
            return $customer;
        }
        return false;
    }

    public function paginate(int $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->latest()
            ->paginate($itemPerPage);
    }

    public function searchAndPaginate(string $escapedKeyword, int $itemPerPage)
    {
        return Customer::where('delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('phone', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($itemPerPage);
    }

    public function retrieveCustomerAddressesByCustomerId(int $customerId)
    {
        return CustomerAddress::where('customer_id', $customerId)->get();
    }
}
