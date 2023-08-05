<?php

namespace Database\Seeders;

use App\Repositories\ISeederRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
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
        $password = Hash::make('Abc12345');
        $this->seederRepository->createAdmin([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => $password,
        ]);
        $this->seederRepository->createAdmin([
            'name' => 'Test admin',
            'email' => 'testadmin@gmail.com',
            'password' => $password,
        ]);
    }
}
