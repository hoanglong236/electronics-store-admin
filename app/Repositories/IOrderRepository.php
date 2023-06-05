<?php

namespace App\Repositories;

interface IOrderRepository
{
    public function update(array $attributes, int $id);
    public function filterCustomOrdersAndPaginate(
        array $searchFields, array $filterFields, string $fromDate, string $toDate, int $itemPerPage
    );
    public function getFilterCustomOrdersIterator(
        array $searchFields, array $filterFields, string $fromDate, string $toDate
    );

    public function getOrderAlongWithCustomerInfoById(int $id);
    public function getCustomOrderItemsByOrderId(int $orderId);
}
