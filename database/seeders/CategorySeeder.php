<?php

namespace Database\Seeders;

use App\Config\Config;
use App\Repositories\ICategoryRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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

        $accessoriesId = $this->categoryRepository->findBySlug('accessories')->id;
        $soundDeviceId = $this->categoryRepository->findBySlug('sound-device')->id;

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
            $this->categoryRepository->create([
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
            $this->categoryRepository->create([
                'parent_id' => $categoryInfo['parentId'],
                'name' => $categoryInfo['name'],
                'slug' => $categoryInfo['slug'],
                'icon_path' => Config::FOLDER_PATH_CATEGORY_ICONS . '/' . $categoryInfo['slug'] . '.png',
                'delete_flag' => false,
            ]);
        }
    }
}
