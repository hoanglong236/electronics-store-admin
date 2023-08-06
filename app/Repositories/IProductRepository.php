<?php

namespace App\Repositories;

interface IProductRepository
{
    public function findById(int $id);
    public function create(array $attributes);
    public function update(array $attributes, int $id);
    public function deleteById(int $id);
    public function searchAndPaginate(
        string $escapedKeyword, string $searchOption, int $itemPerPage
    );

    public function getCustomProductById(int $id);
    public function getProductImagesByProductId(int $productId);
    public function createProductImage(array $attributes);
    public function deleteProductImageById(int $id);
}
