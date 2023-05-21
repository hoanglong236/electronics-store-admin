<?php

namespace Database\Seeders;

use App\ModelConstants\OrderStatusConstants;
use App\ModelConstants\PaymentMethodConstants;
use App\Repositories\ISeederRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    const RANDOM_ORDER_COUNT = 4;
    const RANDOM_PRODUCT_COUNT = 4;
    const RANDOM_CUSTOMER_COUNT = 4;

    private $seederRepository;

    public function __construct(ISeederRepository $seederRepository)
    {
        $this->seederRepository = $seederRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = $this->seederRepository->getRandomCustomersHaveAddress(static::RANDOM_CUSTOMER_COUNT);
        foreach ($customers as $customer) {
            $deliveryAddress = $this->getCustomerDeliveryAddress($customer->id);
            $this->generateRandomOrders(static::RANDOM_ORDER_COUNT, $customer->id, $deliveryAddress);
        }
    }

    private function getCustomerDeliveryAddress($customerId)
    {
        $customerAddress = $this->seederRepository->getRandomCustomerAddressByCustomerId($customerId);

        return '(' . $customerAddress->address_type . ') '
            . $customerAddress->specific_address . ', '
            . $customerAddress->ward . ', '
            . $customerAddress->district . ', '
            . $customerAddress->city;
    }

    private function generateRandomOrders($orderCount, $customerId, $deliveryAddress)
    {
        $orderStatusArray = OrderStatusConstants::toArray();
        $paymentMethods = PaymentMethodConstants::toArray();
        for ($i = 0; $i < $orderCount; $i++) {
            $order = $this->seederRepository->createOrder([
                'customer_id' => $customerId,
                'delivery_address' => $deliveryAddress,
                'status' => $orderStatusArray[mt_rand(0, count($orderStatusArray) - 1)],
                'payment_method' => $paymentMethods[mt_rand(0, count($paymentMethods) - 1)],
            ]);

            $products = $this->seederRepository->getRandomProducts(static::RANDOM_PRODUCT_COUNT);
            foreach ($products as $product) {
                $quantity = mt_rand(1, 2);
                $this->seederRepository->createOrderItem([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $product->price * (1 - $product->discount_percent / 100) * $quantity,
                ]);
            }
        }
    }
}
