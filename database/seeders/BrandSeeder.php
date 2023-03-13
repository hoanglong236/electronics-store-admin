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
            'logo_path' => Constants::BRAND_LOGO_PATH . '/acer.png',
        ]);
        Brand::create([
            'name' => 'Apple',
            'slug' => 'apple',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/apple.png',
        ]);
        Brand::create([
            'name' => 'Asus',
            'slug' => 'asus',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/asus.jpg',
        ]);
        Brand::create([
            'name' => 'Dell',
            'slug' => 'dell',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/dell.jpg',
        ]);
        Brand::create([
            'name' => 'HP',
            'slug' => 'hp',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/hp.png',
        ]);
        Brand::create([
            'name' => 'Huawei',
            'slug' => 'huawei',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/huawei.png',
        ]);
        Brand::create([
            'name' => 'Lenovo',
            'slug' => 'lenovo',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/lenovo.jpg',
        ]);
        Brand::create([
            'name' => 'MSI',
            'slug' => 'msi',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/msi.png',
        ]);
        Brand::create([
            'name' => 'Oppo',
            'slug' => 'oppo',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/oppo.png',
        ]);
        Brand::create([
            'name' => 'Samsung',
            'slug' => 'samsung',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/samsung.png',
        ]);
        Brand::create([
            'name' => 'Xiaomi',
            'slug' => 'xiaomi',
            'logo_path' => Constants::BRAND_LOGO_PATH . '/xiaomi.png',
        ]);
    }
}
