<?php

namespace Database\Seeders;

use App\Libs\Cloud\Storage\FirebaseStorage;
use App\Repositories\IBrandRepository;
use App\Repositories\ICategoryRepository;
use App\Repositories\IProductRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirebaseUploadImageSeeder extends Seeder
{
    private $categoryRepository;
    private $brandRepository;
    private $productRepository;

    public function __construct(
        ICategoryRepository $categoryRepository,
        IBrandRepository $brandRepository,
        IProductRepository $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
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

        $products = $this->productRepository->listAll(['main_image_path']);
        foreach ($products as $product) {
            $imagePaths[] = $product->main_image_path;
        }

        $productImages = $this->productRepository->listAllProductImages(['image_path']);
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
