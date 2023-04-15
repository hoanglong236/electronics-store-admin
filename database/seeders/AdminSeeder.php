<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('Abc12345');
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => $password,
        ]);
        Admin::create([
            'name' => 'Test admin',
            'email' => 'testadmin@gmail.com',
            'password' => $password,
        ]);
    }
}
