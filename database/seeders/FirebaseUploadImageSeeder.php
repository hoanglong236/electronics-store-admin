<?php

namespace Database\Seeders;

use App\Libs\Cloud\Storage\FirebaseStorage;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirebaseUploadImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imagePaths = [];

        $brands = Brand::all('logo_path');
        foreach ($brands as $brand) {
            $imagePaths[] = $brand->logo_path;
        }

        $categories = Category::all('icon_path');
        foreach ($categories as $category) {
            $imagePaths[] = $category->icon_path;
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
        $firebaseStorage = FirebaseStorage::getInstance();
        foreach ($imagePaths as $imagePath) {
            $imageResource = fopen(public_path('storage/') . $imagePath, "r");
            $firebaseStorage->upload($imageResource, $imagePath);
        }
    }
}
