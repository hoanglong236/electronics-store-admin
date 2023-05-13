<?php

namespace Database\Seeders;

use App\Config\Config;
use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandInfoArray = [
            ['name' => 'Acer', 'slug' => 'acer'],
            ['name' => 'Apple', 'slug' => 'apple'],
            ['name' => 'Asus', 'slug' => 'asus'],
            ['name' => 'Dell', 'slug' => 'dell'],
            ['name' => 'HP', 'slug' => 'hp'],
            ['name' => 'Huawei', 'slug' => 'huawei'],
            ['name' => 'Lenovo', 'slug' => 'lenovo'],
            ['name' => 'MSI', 'slug' => 'msi'],
            ['name' => 'Oppo', 'slug' => 'oppo'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Xiaomi', 'slug' => 'xiaomi'],
        ];
        $this->generateBrands($brandInfoArray);
    }

    private function generateBrands($brandInfoArray)
    {
        foreach ($brandInfoArray as $brandInfo) {
            Brand::create([
                'name' => $brandInfo['name'],
                'slug' => $brandInfo['slug'],
                'logo_path' => Config::FOLDER_PATH_BRAND_LOGOS . '/' . $brandInfo['slug'] . '.png',
                'delete_flag' => false,
            ]);
        }
    }
}
