<?php

namespace App\Repositories;

interface ICustomerRepository
{
    public function findById(int $id);
    public function update(array $attributes, int $id);
    public function deleteById(int $id);
    public function searchAndPaginate(string $escapedKeyword, int $itemPerPage);

    public function retrieveCustomerAddressesByCustomerId(int $customerId);
}
