<?php

namespace Database\Seeders;

use App\ModelConstants\OrderStatusConstants;
use App\ModelConstants\PaymentMethodConstants;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    private $randomOrderCount = 4;
    private $randomProductCount = 4;
    private $randomCustomerCount = 4;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = $this->getRandomCustomers($this->randomCustomerCount);
        foreach ($customers as $customer) {
            $deliveryAddress = $this->getCustomerDeliveryAddress($customer->id);
            $this->generateRandomOrders($this->randomOrderCount, $customer->id, $deliveryAddress);
        }
    }

    private function getRandomCustomers($customerCount)
    {
        return DB::table('customers')
            ->join('customer_addresses', 'customer_id', '=', 'customers.id')
            ->select('customers.*')
            ->where([
                'delete_flag' => false,
                'disable_flag' => false
            ])
            ->inRandomOrder()
            ->limit($customerCount)
            ->get();
    }

    private function getCustomerDeliveryAddress($customerId)
    {
        $customerAddress = CustomerAddress::where('customer_id', $customerId)
            ->inRandomOrder()
            ->first();

        return [
            'address' => $customerAddress->specific_address . ', '
                . $customerAddress->ward . ', '
                . $customerAddress->district . ', '
                . $customerAddress->city,
            'address_type' => $customerAddress->address_type,
        ];
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
                'status' => $orderStatusArray[mt_rand(0, count($orderStatusArray) - 1)],
                'payment_method' => $paymentMethods[mt_rand(0, count($paymentMethods) - 1)],
            ]);

            $products = $this->getRandomProducts($this->randomProductCount);
            foreach ($products as $product) {
                $quantity = mt_rand(1, 2);
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
        return Product::where('delete_flag', false)
            ->inRandomOrder()
            ->limit($productCount)
            ->get();
    }
}
