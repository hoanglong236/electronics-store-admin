<?php

namespace Database\Seeders;

use App\Common\Constants;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Kreait\Firebase\Factory;

class FirebaseUploadImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firebaseBucket = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createStorage()
            ->getBucket();


        $brandLogoPaths = [];
        $brands = Brand::all('logo_path');
        foreach ($brands as $brand) {
            array_push($brandLogoPaths, $brand->logo_path);
        }
        $this->uploadImages($firebaseBucket, $brandLogoPaths);

        $categoryIconPaths = [];
        $categories = Category::all('icon_path');
        foreach ($categories as $category) {
            array_push($categoryIconPaths, $category->icon_path);
        }
        $this->uploadImages($firebaseBucket, $categoryIconPaths);

        $productMainImagePaths = [];
        $products = Product::all('main_image_path');
        foreach ($products as $product) {
            array_push($productMainImagePaths, $product->main_image_path);
        }
        $this->uploadImages($firebaseBucket, $productMainImagePaths);

        $productImagePaths = [];
        $productImages = ProductImage::all('image_path');
        foreach ($productImages as $productImage) {
            array_push($productImagePaths, $productImage->image_path);
        }
        $this->uploadImages($firebaseBucket, $productImagePaths);
    }

    private function uploadImages($firebaseBucket, $imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            $imageResource = fopen(public_path('/storage/') . $imagePath, "r");
            $firebaseBucket->upload($imageResource, [
                'name' => Constants::FIREBASE_STORAGE_IMAGES_PATH . $imagePath,
            ]);
        }
    }
}
