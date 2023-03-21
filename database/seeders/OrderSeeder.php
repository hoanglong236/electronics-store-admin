<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = $this->getFirstCustomer();
        $deliveryAddress = $this->getCustomerDeliveryAddress($customer->id);

        $this->generateRandomOrders(3, $customer->id, $deliveryAddress);
    }

    private function generateRandomOrders($orderCount, $customerId, $deliveryAddress)
    {
        $statusEnum = ['Received', 'Processing', 'Delivering', 'Completed', 'Cancelled'];
        for ($i = 0; $i < $orderCount; $i++) {
            $order = Order::create([
                'customer_id' => $customerId,
                'delivery_address' => $deliveryAddress,
                'status' => $statusEnum[rand(0, count($statusEnum) - 1)],
            ]);

            $products = $this->getRandomProducts(2);
            foreach ($products as $product) {
                $quantity = rand(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $product->price * (1 - $product->discount_percent / 100) * $quantity,
                ]);
            }
        }
    }

    private function getRandomProducts($productCount)
    {
        return Product::where('delete_flag', false)->inRandomOrder()->limit($productCount)->get();
    }

    private function getFirstCustomer()
    {
        return Customer::where(['delete_flag' => false, 'disable_flag' => false])->first();
    }

    private function getCustomerDeliveryAddress($customerId)
    {
        $customerAddress = CustomerAddress::where('customer_id', $customerId)->first();
        return $customerAddress->specific_address . ', '
            . $customerAddress->ward . ', '
            . $customerAddress->district . ', '
            . $customerAddress->city;
    }
}
