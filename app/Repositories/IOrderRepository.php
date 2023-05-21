<?php

namespace App\Repositories;

interface IOrderRepository
{
    public function findById(int $id);
    public function getCustomOrderById(int $id);
    public function create(array $attributes);
    public function update(array $attributes, int $id);
    public function paginateCustomOrders(int $itemPerPage);
    public function searchAndFilterCustomOrdersAndPaginate(
        array $filterColumnMap, string $searchOption, string $escapedKeyword, int $itemPerPage
    );

    public function getCustomOrderItemsByOrderId(int $orderId);
}
