<?php

namespace App\Repositories;

interface IProductRepository
{
    public function findById(int $id);
    public function findBySlug(string $slug);
    public function getCustomProductById(int $id);
    public function create(array $attributes);
    public function update(array $attributes, int $id);
    public function deleteById(int $id);
    public function paginateCustomProducts(int $itemPerPage);
    public function searchCustomProductsAndPaginate(
        string $searchOption, string $escapedKeyword, int $itemPerPage
    );
    public function listAll(array $columns = ['*'], bool $withDeleted = false);

    public function retrieveProductImagesByProductId(int $productId);
    public function createProductImage(array $attributes);
    public function deleteProductImageById(int $id);
    public function listAllProductImages(array $columns = ['*']);
}
