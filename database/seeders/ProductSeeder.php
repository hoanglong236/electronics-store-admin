<?php

namespace Database\Seeders;

use App\Common\Constants;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->generateSmartphones();
        $this->generateLaptops();
        $this->generateTablets();
        $this->generateSmartwatches();
        $this->generateAccessories();
    }

    private function generateSmartphones(): void
    {
        $categoryId = Category::where(['slug' => 'phone', 'delete_flag' => false])->first()->id;
        $brandSlugIdMap = $this->getBrandSlugIdMap();

        $productDetailArray = [
            [
                'name' => 'Oppo A16',
                'slug' => 'oppo-a16',
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'OPPO A77s',
                'slug' => 'oppo-a77s',
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'Oppo Reno8 Z',
                'slug' => 'oppo-reno8-z',
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'Xiaomi Redmi 10',
                'slug' => 'xiaomi-redmi-10',
                'brand_slug' => 'xiaomi',
            ],
            [
                'name' => 'POCO X4 GT',
                'slug' => 'poco-x4-gt',
                'brand_slug' => 'xiaomi',
            ],
            [
                'name' => 'Xiaomi 13',
                'slug' => 'xiaomi-13',
                'brand_slug' => 'xiaomi',
            ],
            [
                'name' => 'Samsung Galaxy A04',
                'slug' => 'samsung-galaxy-a04',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy A23',
                'slug' => 'samsung-galaxy-a23',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'slug' => 'samsung-galaxy-s23',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'iPhone 11 64GB',
                'slug' => 'iphone-11',
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'iPhone 12 64GB',
                'slug' => 'iphone-12',
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'iPhone 14 Pro Max 128GB',
                'slug' => 'iphone-14-pro-max',
                'brand_slug' => 'apple',
            ],
        ];

        foreach ($productDetailArray as $productDetail) {
            $product = Product::create([
                'category_id' => $categoryId,
                'brand_id' => $brandSlugIdMap[$productDetail['brand_slug']],
                'name' => $productDetail['name'],
                'slug' => $productDetail['slug'],
                'price' => mt_rand(1, 9) * 10 + mt_rand(2, 9) * 100 + mt_rand(0, 1) * 1000,
                'discount_percent' => mt_rand(1, 4) * 10,
                'quantity' => 1000,
                'warranty_period' => 12,
                'description' => 'None',
                'main_image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productDetail['slug'] . '.jpg',
                'delete_flag' => false,
            ]);
            $this->createProductImages($product->id, $productDetail['slug']);
        }
    }

    private function generateLaptops(): void
    {
        $categoryId = Category::where(['slug' => 'laptop', 'delete_flag' => false])->first()->id;
        $brandSlugIdMap = $this->getBrandSlugIdMap();

        $productDetailArray = [
            [
                'name' => 'MacBook Air M1 2020 256GB',
                'slug' => 'macbook-air-m1-2020',
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'Macbook Air M2 2022 256GB',
                'slug' => 'macbook-air-m2-2022',
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'Laptop Acer Aspire 3 A315-58-53S6',
                'slug' => 'laptop-acer-aspire-3-a315-58-53s6',
                'brand_slug' => 'acer',
            ],
            [
                'name' => 'Laptop Gaming Acer Aspire 7 A715-42G-R05G',
                'slug' => 'laptop-gaming-acer-aspire-7-a715-42g-r05g',
                'brand_slug' => 'acer',
            ],
            [
                'name' => 'Laptop Asus Vivobook 14 X1402ZA-EB100W',
                'slug' => 'laptop-asus-vivobook-14-x1402za-eb100w',
                'brand_slug' => 'asus',
            ],
            [
                'name' => 'Laptop ASUS TUF Gaming F15 FX506HC-HN144W',
                'slug' => 'laptop-asus-tuf-gaming-f15-fx506hc-hn144w',
                'brand_slug' => 'asus',
            ],
            [
                'name' => 'Laptop Dell Inspiron 15 3511 JNM5H',
                'slug' => 'laptop-dell-inspiron-15-3511-jnm5h',
                'brand_slug' => 'dell',
            ],
            [
                'name' => 'Laptop Dell Gaming G15 5511',
                'slug' => 'laptop-dell-gaming-g15-5511',
                'brand_slug' => 'dell',
            ],
            [
                'name' => 'Laptop HP 245 G8 53Y18PA',
                'slug' => 'laptop-hp-245-g8-53y18pa',
                'brand_slug' => 'hp',
            ],
            [
                'name' => 'Laptop HP Gaming Victus 15-FA0031DX 6503849',
                'slug' => 'laptop-hp-gaming-victus-15-fa0031dx-6503849',
                'brand_slug' => 'hp',
            ],
            [
                'name' => 'Laptop Lenovo Ideapad 3 15IAU7 82RK001GVN',
                'slug' => 'laptop-lenovo-ideapad-3-15iau7-82rk001gvn',
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Laptop Lenovo Ideapad Gaming 3 15IHU6 82K101B5VN',
                'slug' => 'laptop-lenovo-ideapad-gaming-3-15ihu6-82k101b5vn',
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Laptop MSI Modern 14 B11MOU-1028VN',
                'slug' => 'laptop-msi-modern-14-b11mou-1028vn',
                'brand_slug' => 'msi',
            ],
            [
                'name' => 'Laptop MSI Gaming GF63 10SC 804VN',
                'slug' => 'laptop-msi-gaming-gf63-10sc-804vn',
                'brand_slug' => 'msi',
            ],
        ];

        foreach ($productDetailArray as $productDetail) {
            $product = Product::create([
                'category_id' => $categoryId,
                'brand_id' => $brandSlugIdMap[$productDetail['brand_slug']],
                'name' => $productDetail['name'],
                'slug' => $productDetail['slug'],
                'price' => mt_rand(1, 9) * 10 + mt_rand(4, 9) * 100 + mt_rand(0, 1) * 1000,
                'discount_percent' => mt_rand(1, 4) * 10,
                'quantity' => 1000,
                'warranty_period' => 24,
                'description' => 'None',
                'main_image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productDetail['slug'] . '.jpg',
                'delete_flag' => false,
            ]);
            $this->createProductImages($product->id, $productDetail['slug']);
        }
    }

    private function generateTablets(): void
    {
        $categoryId = Category::where(['slug' => 'tablet', 'delete_flag' => false])->first()->id;
        $brandSlugIdMap = $this->getBrandSlugIdMap();

        $productDetailArray = [
            [
                'name' => 'iPad Air 5 (2022) 256GB',
                'slug' => 'ipad-air-5-256gb',
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'iPad mini 6 WiFi 64GB',
                'slug' => 'ipad-mini-6',
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'OPPO Pad Air',
                'slug' => 'oppo-pad-air',
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'Huawei Matepad 2022 128GB',
                'slug' => 'huawei-matepad-2022',
                'brand_slug' => 'huawei',
            ],
            [
                'name' => 'Lenovo Tab M10 Gen 2',
                'slug' => 'lenovo-tab-m10-gen-2',
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Lenovo Yoga Tab 11',
                'slug' => 'lenovo-yoga-tab-11',
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Samsung Galaxy Tab A8 (2022)',
                'slug' => 'samsung-galaxy-tab-a8',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy Tab S7 FE (4G)',
                'slug' => 'samsung-galaxy-tab-s7-fe',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy Tab S7 FE (4G)',
                'slug' => 'samsung-galaxy-tab-s7-fe',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy Tab S8 Plus 5G',
                'slug' => 'samsung-galaxy-tab-s8-plus',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Xiaomi Mi Pad 5 256GB',
                'slug' => 'xiaomi-mi-pad-5-256gb',
                'brand_slug' => 'xiaomi',
            ],
        ];

        foreach ($productDetailArray as $productDetail) {
            $product = Product::create([
                'category_id' => $categoryId,
                'brand_id' => $brandSlugIdMap[$productDetail['brand_slug']],
                'name' => $productDetail['name'],
                'slug' => $productDetail['slug'],
                'price' => mt_rand(1, 9) * 10 + mt_rand(4, 9) * 100 + mt_rand(0, 1) * 1000,
                'discount_percent' => mt_rand(1, 4) * 10,
                'quantity' => 1000,
                'warranty_period' => 24,
                'description' => 'None',
                'main_image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productDetail['slug'] . '.jpg',
                'delete_flag' => false,
            ]);
            $this->createProductImages($product->id, $productDetail['slug']);
        }
    }

    private function generateSmartwatches()
    {
        $categoryId = Category::where(['slug' => 'smartwatch', 'delete_flag' => false])->first()->id;
        $brandSlugIdMap = $this->getBrandSlugIdMap();

        $productDetailArray = [
            [
                'name' => 'Apple Watch SE 2022 40mm',
                'slug' => 'apple-watch-se-2022-40mm',
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'Samsung Galaxy Watch 5',
                'slug' => 'samsung-galaxy-watch-5',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Xiaomi Watch S1 Pro',
                'slug' => 'xiaomi-watch-s1-pro',
                'brand_slug' => 'xiaomi',
            ],
        ];

        foreach ($productDetailArray as $productDetail) {
            $product = Product::create([
                'category_id' => $categoryId,
                'brand_id' => $brandSlugIdMap[$productDetail['brand_slug']],
                'name' => $productDetail['name'],
                'slug' => $productDetail['slug'],
                'price' => mt_rand(1, 9) * 10 + mt_rand(5, 9) * 100,
                'discount_percent' => mt_rand(1, 4) * 10,
                'quantity' => 1000,
                'warranty_period' => 24,
                'description' => 'None',
                'main_image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productDetail['slug'] . '.jpg',
                'delete_flag' => false,
            ]);
            $this->createProductImages($product->id, $productDetail['slug']);
        }
    }

    private function generateAccessories()
    {
        $categoryId = Category::where(['slug' => 'accessories', 'delete_flag' => false])->first()->id;
        $brandSlugIdMap = $this->getBrandSlugIdMap();

        $productDetailArray = [
            [
                'name' => 'Wireless earphones Samsung Galaxy Buds Live',
                'slug' => 'samsung-galaxy-buds-live',
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Apple AirPods Pro 2022',
                'slug' => 'apple-airpods-pro-2022',
                'brand_slug' => 'apple',
            ],
        ];

        foreach ($productDetailArray as $productDetail) {
            $product = Product::create([
                'category_id' => $categoryId,
                'brand_id' => $brandSlugIdMap[$productDetail['brand_slug']],
                'name' => $productDetail['name'],
                'slug' => $productDetail['slug'],
                'price' => mt_rand(1, 9) * 10 + mt_rand(5, 9) * 100,
                'discount_percent' => mt_rand(1, 4) * 10,
                'quantity' => 1000,
                'warranty_period' => 24,
                'description' => 'None',
                'main_image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productDetail['slug'] . '.jpg',
                'delete_flag' => false,
            ]);
            $this->createProductImages($product->id, $productDetail['slug']);
        }
    }

    private function getBrandSlugIdMap()
    {
        $brands = Brand::where(['delete_flag' => false])->get();
        $map = [];
        foreach ($brands as $brand) {
            $map[$brand->slug] = $brand->id;
        }
        return $map;
    }

    private function createProductImages($productId, $productSlug)
    {
        ProductImage::create([
            'product_id' => $productId,
            'image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productSlug . '.jpg',
        ]);
        ProductImage::create([
            'product_id' => $productId,
            'image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productSlug . '-1.jpg',
        ]);
        ProductImage::create([
            'product_id' => $productId,
            'image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productSlug . '-2.jpg',
        ]);
        ProductImage::create([
            'product_id' => $productId,
            'image_path' => Constants::PRODUCT_IMAGE_PATH . '/' . $productSlug . '-3.jpg',
        ]);
    }
}
