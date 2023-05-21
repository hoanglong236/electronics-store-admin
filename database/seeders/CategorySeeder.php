<?php

namespace Database\Seeders;

use App\Config\Config;
use App\Repositories\ISeederRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
        $categoryInfoArray = [
            ['name' => 'Phone', 'slug' => 'phone'],
            ['name' => 'Laptop', 'slug' => 'laptop'],
            ['name' => 'Tablet', 'slug' => 'tablet'],
            ['name' => 'Smartwatch', 'slug' => 'smartwatch'],
            ['name' => 'Sound device', 'slug' => 'sound-device'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ];
        $this->generateRootCategories($categoryInfoArray);

        $accessoriesId = $this->seederRepository->findCategoryBySlug('accessories')->id;
        $soundDeviceId = $this->seederRepository->findCategoryBySlug('sound-device')->id;

        $childCategoriesInfoArray = [
            ['name' => 'Keyboard', 'slug' => 'keyboard', 'parentId' => $accessoriesId],
            ['name' => 'Mouse', 'slug' => 'mouse', 'parentId' => $accessoriesId],
            ['name' => 'Adaptor', 'slug' => 'adaptor', 'parentId' => $accessoriesId],
            ['name' => 'Cable', 'slug' => 'cable', 'parentId' => $accessoriesId],
            ['name' => 'Headphone', 'slug' => 'headphone', 'parentId' => $soundDeviceId],
            ['name' => 'Earphone', 'slug' => 'earphone', 'parentId' => $soundDeviceId],
        ];
        $this->generateChildCategories($childCategoriesInfoArray);
    }

    private function generateRootCategories($categoryInfoArray)
    {
        foreach ($categoryInfoArray as $categoryInfo) {
            $this->seederRepository->createCategory([
                'name' => $categoryInfo['name'],
                'slug' => $categoryInfo['slug'],
                'icon_path' => Config::FOLDER_PATH_CATEGORY_ICONS . '/' . $categoryInfo['slug'] . '.png',
                'delete_flag' => false,
            ]);
        }
    }

    private function generateChildCategories($categoryInfoArray)
    {
        foreach ($categoryInfoArray as $categoryInfo) {
            $this->seederRepository->createCategory([
                'parent_id' => $categoryInfo['parentId'],
                'name' => $categoryInfo['name'],
                'slug' => $categoryInfo['slug'],
                'icon_path' => Config::FOLDER_PATH_CATEGORY_ICONS . '/' . $categoryInfo['slug'] . '.png',
                'delete_flag' => false,
            ]);
        }
    }
}
