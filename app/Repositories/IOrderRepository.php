<?php

namespace App\Repositories;

interface IOrderRepository
{
    public function update(array $attributes, int $id);
    public function filterCustomOrdersAndPaginate(array $conditions, int $itemPerPage);
    public function getFilterCustomOrdersIterator(array $conditions);
    public function getOrderAndCustomerInfoByOrderId(int $orderId);
    public function getCustomOrderItemsByOrderId(int $orderId);
}
