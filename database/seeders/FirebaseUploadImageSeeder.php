<?php

namespace Database\Seeders;

use App\Libs\Cloud\Storage\FirebaseStorage;
use App\Repositories\ISeederRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirebaseUploadImageSeeder extends Seeder
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
        $imagePaths = [];

        $categories = $this->seederRepository->listAllCategories(['icon_path']);
        foreach ($categories as $category) {
            $imagePaths[] = $category->icon_path;
        }

        $brands = $this->seederRepository->listAllBrands(['logo_path']);
        foreach ($brands as $brand) {
            $imagePaths[] = $brand->logo_path;
        }

        $products = $this->seederRepository->listAllProducts(['main_image_path']);
        foreach ($products as $product) {
            $imagePaths[] = $product->main_image_path;
        }

        $productImages = $this->seederRepository->listAllProductImages(['image_path']);
        foreach ($productImages as $productImage) {
            $imagePaths[] = $productImage->image_path;
        }

        $this->uploadImages($imagePaths);
    }

    private function uploadImages($imagePaths)
    {
        $firebaseStorage = new FirebaseStorage();
        foreach ($imagePaths as $imagePath) {
            $imageResource = fopen(public_path('storage/') . $imagePath, "r");
            $firebaseStorage->upload($imageResource, $imagePath);
        }
    }
}
