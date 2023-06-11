<?php

namespace Database\Seeders;

use App\Models\Constants\AddressType;
use App\Repositories\ISeederRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    const RANDOM_PRODUCT_COUNT = 3;
    const RANDOM_CUSTOMER_COUNT = 8;
    const NON_HASH_PASSWORD = 'Abc12345';

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
        $this->generateMainCustomer();
        $this->generateCustomers();
    }

    private function generateMainCustomer()
    {
        $customer = $this->seederRepository->createCustomer([
            'name' => 'Customer Zero',
            'gender' => true,
            'phone' => '1234567890',
            'email' => 'customer@gmail.com',
            'password' => Hash::make(static::NON_HASH_PASSWORD),
            'disable_flag' => false,
            'delete_flag' => false,
        ]);
        $this->generateCustomerAddresses($customer->id);
        $this->seederRepository->createCart(['customer_id' => $customer->id]);
    }

    private function generateCustomers()
    {
        $password = Hash::make(static::NON_HASH_PASSWORD);
        for ($i = 0; $i < static::RANDOM_CUSTOMER_COUNT; $i++) {
            $customer = $this->seederRepository->createCustomer([
                'name' => 'Customer ' . ($i + 1),
                'gender' => mt_rand(0, 1) === 1,
                'phone' => '123456789' . ($i + 1),
                'email' => 'customer' . ($i + 1) . '@gmail.com',
                'password' => $password,
                'disable_flag' => mt_rand(0, 1) === 1,
                'delete_flag' => false,
            ]);
            $this->generateCustomerAddresses($customer->id);
            $this->seederRepository->createCart(['customer_id' => $customer->id]);
        }
    }

    private function generateCustomerAddresses($customerId)
    {
        $addresses = [
            [
                'city' => 'Thanh pho Ho Chi Minh',
                'district' => 'Quan Tan Binh',
                'ward' => 'Phuong 2',
                'specific_address' => 'Toa nha Waseco',
                'address_type' => AddressType::HOME,
                'customer_id' => $customerId,
                'default_flag' => true,
            ],
            [
                'city' => 'Thanh pho Can Tho',
                'district' => 'Quan Ninh Kieu',
                'ward' => 'Phuong Xuan Khanh',
                'specific_address' => 'DHCT Khu 2, Duong 3/2',
                'address_type' => AddressType::OFFICE,
                'customer_id' => $customerId,
                'default_flag' => false,
            ],
        ];

        foreach ($addresses as $address) {
            $this->seederRepository->createCustomerAddress($address);
        }
    }
}
