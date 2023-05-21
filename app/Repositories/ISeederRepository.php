<?php

namespace App\Repositories;

interface ISeederRepository
{
    public function createAdmin(array $attributes);

    public function createBrand(array $attributes);
    public function listAllBrands(array $columns = ['*']);

    public function createCategory(array $attributes);
    public function findCategoryBySlug(string $slug);
    public function listAllCategories(array $columns = ['*']);

    public function createProduct(array $attributes);
    public function createProductImage(array $attributes);
    public function listAllProducts(array $columns = ['*']);
    public function listAllProductImages(array $columns = ['*']);
    public function getRandomProducts(int $randomCount);

    public function createCustomer(array $attributes);
    public function createCustomerAddress(array $attributes);
    public function createCart(array $attributes);
    public function getRandomCustomersHaveAddress(int $randomCount);
    public function getRandomCustomerAddressByCustomerId(int $customerId);

    public function createOrder(array $attributes);
    public function createOrderItem(array $attributes);
}
