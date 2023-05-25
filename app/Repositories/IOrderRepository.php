<?php

namespace App\Repositories;

interface IOrderRepository
{
    public function findById(int $id);
    public function getCustomOrderById(int $id);
    public function update(array $attributes, int $id);
    public function paginateCustomOrders(int $itemPerPage);
    public function filterCustomOrdersAndPaginate(
        array $searchFields, array $filterFields, array $sortFields, int $itemPerPage
    );

    public function getCustomOrderItemsByOrderId(int $orderId);
}
