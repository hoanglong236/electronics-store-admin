<?php

namespace Database\Seeders;

use App\ModelConstants\CustomerAddressType;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->generateMainCustomer();
        $this->generateCustomers();
    }

    private function generateMainCustomer() {
        $customer = Customer::create([
            'name' => 'Customer Zero',
            'gender' => true,
            'phone' => '1234567890',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => false,
            'delete_flag' => false,
        ]);

        CustomerAddress::create([
            'customer_id' => $customer->id,
            'city' => 'Thanh pho Ho Chi Minh',
            'district' => 'Quan Tan Binh',
            'ward' => 'Phuong 2',
            'specific_address' => 'Toa nha Waseco',
            'address_type' => CustomerAddressType::HOME,
            'default_flag' => true,
        ]);
        CustomerAddress::create([
            'customer_id' => $customer->id,
            'city' => 'Thanh pho Can Tho',
            'district' => 'Quan Ninh Kieu',
            'ward' => 'Phuong Xuan Khanh',
            'specific_address' => 'DHCT Khu 2, Duong 3/2',
            'address_type' => CustomerAddressType::OFFICE,
            'default_flag' => false,
        ]);
    }

    private function generateCustomers() {
        Customer::create([
            'name' => 'Customer One',
            'gender' => false,
            'phone' => '1234567891',
            'email' => 'customer-one@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => false,
            'delete_flag' => false,
        ]);
        Customer::create([
            'name' => 'Customer Two',
            'gender' => false,
            'phone' => '1234567892',
            'email' => 'customer-two@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => true,
            'delete_flag' => false,
        ]);
        Customer::create([
            'name' => 'Customer Three',
            'gender' => false,
            'phone' => '1234567892',
            'email' => 'customer-three@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => true,
            'delete_flag' => false,
        ]);
        Customer::create([
            'name' => 'Customer Four',
            'gender' => false,
            'phone' => '1234567892',
            'email' => 'customer-fout@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => true,
            'delete_flag' => false,
        ]);
        Customer::create([
            'name' => 'Customer Five',
            'gender' => false,
            'phone' => '1234567892',
            'email' => 'customer-five@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => true,
            'delete_flag' => false,
        ]);
        Customer::create([
            'name' => 'Customer Six',
            'gender' => false,
            'phone' => '1234567892',
            'email' => 'customer-six@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => true,
            'delete_flag' => false,
        ]);
        Customer::create([
            'name' => 'Customer Seven',
            'gender' => false,
            'phone' => '1234567892',
            'email' => 'customer-seven@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => true,
            'delete_flag' => false,
        ]);
        Customer::create([
            'name' => 'Customer Eight',
            'gender' => false,
            'phone' => '1234567892',
            'email' => 'customer-eight@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => true,
            'delete_flag' => false,
        ]);
    }
}
