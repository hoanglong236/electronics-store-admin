<?php

namespace Database\Seeders;

use App\Models\Customer;
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
        Customer::create([
            'name' => 'Customer Zero',
            'gender' => true,
            'phone' => '1234567890',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('Abc12345'),
            'disable_flag' => false,
            'delete_flag' => false,
        ]);
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
    }
}
