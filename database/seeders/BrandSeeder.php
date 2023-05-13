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
        Brand::create([
            'name' => 'Acer',
            'slug' => 'acer',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/acer.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Apple',
            'slug' => 'apple',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/apple.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Asus',
            'slug' => 'asus',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/asus.jpg',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Dell',
            'slug' => 'dell',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/dell.jpg',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'HP',
            'slug' => 'hp',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/hp.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Huawei',
            'slug' => 'huawei',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/huawei.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Lenovo',
            'slug' => 'lenovo',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/lenovo.jpg',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'MSI',
            'slug' => 'msi',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/msi.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Oppo',
            'slug' => 'oppo',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/oppo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Samsung',
            'slug' => 'samsung',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/samsung.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Xiaomi',
            'slug' => 'xiaomi',
            'logo_path' => Config::FOLDER_PATH_BRAND_LOGO . '/xiaomi.png',
            'delete_flag' => false,
        ]);
    }
}
