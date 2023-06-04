<?php

namespace App\Repositories;

interface IProductRepository
{
    public function findById(int $id);
    public function create(array $attributes);
    public function update(array $attributes, int $id);
    public function deleteById(int $id);
    public function paginateCustomProducts(int $itemPerPage);
    public function searchCustomProductsAndPaginate(
        string $searchOption, string $escapedKeyword, int $itemPerPage
    );

    public function getCustomProductById(int $id);
    public function retrieveProductImagesByProductId(int $productId);
    public function createProductImage(array $attributes);
    public function deleteProductImageById(int $id);
}
