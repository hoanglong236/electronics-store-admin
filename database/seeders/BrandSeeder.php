<?php

namespace Database\Seeders;

use App\Common\Constants;
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
            'logo_path' => Constants::BRAND_LOGO_PATH . '/acer-logo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Apple',
            'slug' => 'apple',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/apple-logo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Asus',
            'slug' => 'asus',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/asus-logo.jpg',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Dell',
            'slug' => 'dell',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/dell-logo.jpg',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'HP',
            'slug' => 'hp',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/hp-logo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Huawei',
            'slug' => 'huawei',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/huawei-logo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Lenovo',
            'slug' => 'lenovo',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/lenovo-logo.jpg',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'MSI',
            'slug' => 'msi',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/msi-logo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Oppo',
            'slug' => 'oppo',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/oppo-logo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Samsung',
            'slug' => 'samsung',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/samsung-logo.png',
            'delete_flag' => false,
        ]);
        Brand::create([
            'name' => 'Xiaomi',
            'slug' => 'xiaomi',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/xiaomi-logo.png',
            'delete_flag' => false,
        ]);
    }
}
