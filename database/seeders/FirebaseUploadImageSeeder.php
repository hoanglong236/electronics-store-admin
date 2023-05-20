<?php

namespace Database\Seeders;

use App\Libs\Cloud\Storage\FirebaseStorage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\IBrandRepository;
use App\Repositories\ICategoryRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirebaseUploadImageSeeder extends Seeder
{
    private $categoryRepository;
    private $brandRepository;

    public function __construct(
        ICategoryRepository $categoryRepository,
        IBrandRepository $brandRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePaths = [];

        $categories = $this->categoryRepository->listAll(['icon_path']);
        foreach ($categories as $category) {
            $imagePaths[] = $category->icon_path;
        }

        $brands = $this->brandRepository->listAll(['logo_path']);
        foreach ($brands as $brand) {
            $imagePaths[] = $brand->logo_path;
        }

        $products = Product::all('main_image_path');
        foreach ($products as $product) {
            $imagePaths[] = $product->main_image_path;
        }

        $productImages = ProductImage::all('image_path');
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
