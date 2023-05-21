<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

class SeederRepository implements ISeederRepository
{
    public function createAdmin(array $attributes)
    {
        return Admin::create($attributes);
    }

    public function createBrand(array $attributes)
    {
        return Brand::create($attributes);
    }

    public function listAllBrands(array $columns = ['*'])
    {
        return Brand::all($columns);
    }

    public function createCategory(array $attributes)
    {
        return Category::create($attributes);
    }

    public function findCategoryBySlug(string $slug)
    {
        return Category::where(['slug' => $slug, 'delete_flag' => false])
            ->first();
    }

    public function listAllCategories(array $columns = ['*'])
    {
        return Category::all($columns);
    }

    public function createProduct(array $attributes)
    {
        return Product::create($attributes);
    }

    public function createProductImage(array $attributes)
    {
        return ProductImage::create($attributes);
    }

    public function listAllProducts(array $columns = ['*'])
    {
        return Product::all($columns);
    }

    public function listAllProductImages(array $columns = ['*'])
    {
        return ProductImage::all($columns);
    }

    public function getRandomProducts(int $randomCount)
    {
        return Product::where('delete_flag', false)
            ->inRandomOrder()
            ->limit($randomCount)
            ->get();
    }

    public function createCustomer(array $attributes)
    {
        return Customer::create($attributes);
    }

    public function createCustomerAddress(array $attributes)
    {
        return CustomerAddress::create($attributes);
    }

    public function createCart(array $attributes)
    {
        return Cart::create($attributes);
    }

    public function getRandomCustomersHaveAddress(int $randomCount)
    {
        return DB::table('customers')
            ->join('customer_addresses', 'customer_addresses.customer_id', '=', 'customers.id')
            ->select('customers.*')
            ->distinct()
            ->where([
                'customers.delete_flag' => false,
                'customers.disable_flag' => false
            ])
            ->inRandomOrder()
            ->limit($randomCount)
            ->get();
    }

    public function getRandomCustomerAddressByCustomerId(int $customerId)
    {
        return CustomerAddress::where('customer_id', $customerId)
            ->inRandomOrder()
            ->first();
    }

    public function createOrder(array $attributes)
    {
        return Order::create($attributes);
    }

    public function createOrderItem(array $attributes)
    {
        return OrderItem::create($attributes);
    }
}
