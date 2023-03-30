<?php

namespace Database\Seeders;

use App\ModelConstants\OrderStatusConstants;
use App\ModelConstants\PaymentMethodConstants;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    private $orderRandomCount = 5;
    private $productRandomCount = 3;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = $this->getFirstCustomer();
        $deliveryAddress = $this->getCustomerDeliveryAddress($customer->id);

        $this->generateRandomOrders($this->orderRandomCount, $customer->id, $deliveryAddress);
    }

    private function generateRandomOrders($orderCount, $customerId, $deliveryAddress)
    {
        $orderStatusArray = OrderStatusConstants::toArray();
        $paymentMethods = PaymentMethodConstants::toArray();
        for ($i = 0; $i < $orderCount; $i++) {
            $order = Order::create([
                'customer_id' => $customerId,
                'delivery_address' => $deliveryAddress['address'],
                'address_type' => $deliveryAddress['address_type'],
                'status' => $orderStatusArray[rand(0, count($orderStatusArray) - 1)],
                'payment_method' => $paymentMethods[rand(0, count($paymentMethods) - 1)],
            ]);

            $products = $this->getRandomProducts($this->productRandomCount);
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
        return [
            'address' => $customerAddress->specific_address . ', '
                . $customerAddress->ward . ', '
                . $customerAddress->district . ', '
                . $customerAddress->city,
            'address_type' => $customerAddress->address_type,
        ];
    }
}
