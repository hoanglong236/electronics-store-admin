<?php

namespace Database\Seeders;

use App\Common\Constants;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Phone',
            'slug' => 'phone',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/phone.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'name' => 'Laptop',
            'slug' => 'laptop',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/laptop.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'name' => 'Tablet',
            'slug' => 'tablet',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/tablet.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'name' => 'Sound device',
            'slug' => 'sound-device',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/sound-device.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'name' => 'Accessories',
            'slug' => 'accessories',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/accessories.png',
            'delete_flag' => false,
        ]);

        $accessoriesId = Category::where('slug', 'accessories')->first()->id;
        Category::create([
            'parent_id' => $accessoriesId,
            'name' => 'Keyboard',
            'slug' => 'keyboard',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/keyboard.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'parent_id' => $accessoriesId,
            'name' => 'Mouse',
            'slug' => 'mouse',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/mouse.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'parent_id' => $accessoriesId,
            'name' => 'Adapter',
            'slug' => 'adapter',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/adapter.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'parent_id' => $accessoriesId,
            'name' => 'Cable',
            'slug' => 'cable',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/cable.png',
            'delete_flag' => false,
        ]);

        $soundDeviceId = Category::where('slug', 'sound-device')->first()->id;
        Category::create([
            'parent_id' => $soundDeviceId,
            'name' => 'Headphone',
            'slug' => 'headphone',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/headphone.png',
            'delete_flag' => false,
        ]);
        Category::create([
            'parent_id' => $soundDeviceId,
            'name' => 'Earphone',
            'slug' => 'earphone',
            'icon_path' => Constants::CATEGORY_ICON_PATH . '/earphone.png',
            'delete_flag' => false,
        ]);
    }
}
