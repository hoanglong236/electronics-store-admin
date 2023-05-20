<?php

namespace Database\Seeders;

use App\Config\Config;
use App\Repositories\IBrandRepository;
use App\Repositories\ICategoryRepository;
use App\Repositories\IProductRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
        $this->generateSmartphones();
        $this->generateLaptops();
        $this->generateTablets();
        $this->generateSmartwatches();
        $this->generateAccessories();
    }

    private function generateSmartphones(): void
    {
        $category = $this->categoryRepository->findBySlug('phone');
        $productInfoArray = [
            [
                'name' => 'Oppo A16',
                'slug' => 'oppo-a16',
                'category_id' => $category->id,
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'OPPO A77s',
                'slug' => 'oppo-a77s',
                'category_id' => $category->id,
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'Oppo Reno8 Z',
                'slug' => 'oppo-reno8-z',
                'category_id' => $category->id,
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'Xiaomi Redmi 10',
                'slug' => 'xiaomi-redmi-10',
                'category_id' => $category->id,
                'brand_slug' => 'xiaomi',
            ],
            [
                'name' => 'POCO X4 GT',
                'slug' => 'poco-x4-gt',
                'category_id' => $category->id,
                'brand_slug' => 'xiaomi',
            ],
            [
                'name' => 'Xiaomi 13',
                'slug' => 'xiaomi-13',
                'category_id' => $category->id,
                'brand_slug' => 'xiaomi',
            ],
            [
                'name' => 'Samsung Galaxy A04',
                'slug' => 'samsung-galaxy-a04',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy A23',
                'slug' => 'samsung-galaxy-a23',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'slug' => 'samsung-galaxy-s23',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'iPhone 11 64GB',
                'slug' => 'iphone-11',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'iPhone 12 64GB',
                'slug' => 'iphone-12',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'iPhone 14 Pro Max 128GB',
                'slug' => 'iphone-14-pro-max',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
        ];
        $this->generateProducts($productInfoArray);
    }

    private function generateLaptops(): void
    {
        $category = $this->categoryRepository->findBySlug('laptop');
        $productInfoArray = [
            [
                'name' => 'MacBook Air M1 2020 256GB',
                'slug' => 'macbook-air-m1-2020',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'Macbook Air M2 2022 256GB',
                'slug' => 'macbook-air-m2-2022',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'Laptop Acer Aspire 3 A315-58-53S6',
                'slug' => 'laptop-acer-aspire-3-a315-58-53s6',
                'category_id' => $category->id,
                'brand_slug' => 'acer',
            ],
            [
                'name' => 'Laptop Gaming Acer Aspire 7 A715-42G-R05G',
                'slug' => 'laptop-gaming-acer-aspire-7-a715-42g-r05g',
                'category_id' => $category->id,
                'brand_slug' => 'acer',
            ],
            [
                'name' => 'Laptop Asus Vivobook 14 X1402ZA-EB100W',
                'slug' => 'laptop-asus-vivobook-14-x1402za-eb100w',
                'category_id' => $category->id,
                'brand_slug' => 'asus',
            ],
            [
                'name' => 'Laptop ASUS TUF Gaming F15 FX506HC-HN144W',
                'slug' => 'laptop-asus-tuf-gaming-f15-fx506hc-hn144w',
                'category_id' => $category->id,
                'brand_slug' => 'asus',
            ],
            [
                'name' => 'Laptop Dell Inspiron 15 3511 JNM5H',
                'slug' => 'laptop-dell-inspiron-15-3511-jnm5h',
                'category_id' => $category->id,
                'brand_slug' => 'dell',
            ],
            [
                'name' => 'Laptop Dell Gaming G15 5511',
                'slug' => 'laptop-dell-gaming-g15-5511',
                'category_id' => $category->id,
                'brand_slug' => 'dell',
            ],
            [
                'name' => 'Laptop HP 245 G8 53Y18PA',
                'slug' => 'laptop-hp-245-g8-53y18pa',
                'category_id' => $category->id,
                'brand_slug' => 'hp',
            ],
            [
                'name' => 'Laptop HP Gaming Victus 15-FA0031DX 6503849',
                'slug' => 'laptop-hp-gaming-victus-15-fa0031dx-6503849',
                'category_id' => $category->id,
                'brand_slug' => 'hp',
            ],
            [
                'name' => 'Laptop Lenovo Ideapad 3 15IAU7 82RK001GVN',
                'slug' => 'laptop-lenovo-ideapad-3-15iau7-82rk001gvn',
                'category_id' => $category->id,
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Laptop Lenovo Ideapad Gaming 3 15IHU6 82K101B5VN',
                'slug' => 'laptop-lenovo-ideapad-gaming-3-15ihu6-82k101b5vn',
                'category_id' => $category->id,
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Laptop MSI Modern 14 B11MOU-1028VN',
                'slug' => 'laptop-msi-modern-14-b11mou-1028vn',
                'category_id' => $category->id,
                'brand_slug' => 'msi',
            ],
            [
                'name' => 'Laptop MSI Gaming GF63 10SC 804VN',
                'slug' => 'laptop-msi-gaming-gf63-10sc-804vn',
                'category_id' => $category->id,
                'brand_slug' => 'msi',
            ],
        ];
        $this->generateProducts($productInfoArray);
    }

    private function generateTablets(): void
    {
        $category = $this->categoryRepository->findBySlug('tablet');
        $productInfoArray = [
            [
                'name' => 'iPad Air 5 (2022) 256GB',
                'slug' => 'ipad-air-5-256gb',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'iPad mini 6 WiFi 64GB',
                'slug' => 'ipad-mini-6',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'OPPO Pad Air',
                'slug' => 'oppo-pad-air',
                'category_id' => $category->id,
                'brand_slug' => 'oppo',
            ],
            [
                'name' => 'Huawei Matepad 2022 128GB',
                'slug' => 'huawei-matepad-2022',
                'category_id' => $category->id,
                'brand_slug' => 'huawei',
            ],
            [
                'name' => 'Lenovo Tab M10 Gen 2',
                'slug' => 'lenovo-tab-m10-gen-2',
                'category_id' => $category->id,
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Lenovo Yoga Tab 11',
                'slug' => 'lenovo-yoga-tab-11',
                'category_id' => $category->id,
                'brand_slug' => 'lenovo',
            ],
            [
                'name' => 'Samsung Galaxy Tab A8 (2022)',
                'slug' => 'samsung-galaxy-tab-a8',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy Tab S7 FE (4G)',
                'slug' => 'samsung-galaxy-tab-s7-fe',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy Tab S7 FE (4G)',
                'slug' => 'samsung-galaxy-tab-s7-fe',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Samsung Galaxy Tab S8 Plus 5G',
                'slug' => 'samsung-galaxy-tab-s8-plus',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Xiaomi Mi Pad 5 256GB',
                'slug' => 'xiaomi-mi-pad-5-256gb',
                'category_id' => $category->id,
                'brand_slug' => 'xiaomi',
            ],
        ];
        $this->generateProducts($productInfoArray);
    }

    private function generateSmartwatches()
    {
        $category = $this->categoryRepository->findBySlug('smartwatch');
        $productInfoArray = [
            [
                'name' => 'Apple Watch SE 2022 40mm',
                'slug' => 'apple-watch-se-2022-40mm',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
            [
                'name' => 'Samsung Galaxy Watch 5',
                'slug' => 'samsung-galaxy-watch-5',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Xiaomi Watch S1 Pro',
                'slug' => 'xiaomi-watch-s1-pro',
                'category_id' => $category->id,
                'brand_slug' => 'xiaomi',
            ],
        ];
        $this->generateProducts($productInfoArray);
    }

    private function generateAccessories()
    {
        $category = $this->categoryRepository->findBySlug('accessories');
        $productInfoArray = [
            [
                'name' => 'Wireless earphones Samsung Galaxy Buds Live',
                'slug' => 'samsung-galaxy-buds-live',
                'category_id' => $category->id,
                'brand_slug' => 'samsung',
            ],
            [
                'name' => 'Apple AirPods Pro 2022',
                'slug' => 'apple-airpods-pro-2022',
                'category_id' => $category->id,
                'brand_slug' => 'apple',
            ],
        ];
        $this->generateProducts($productInfoArray);
    }

    private function getBrandSlugIdMap()
    {
        $miniBrands = $this->brandRepository->listAll(['slug', 'id']);
        $map = [];

        foreach ($miniBrands as $miniBrand) {
            $map[$miniBrand->slug] = $miniBrand->id;
        }

        return $map;
    }

    private function generateProducts($productInfoArray)
    {
        $brandSlugIdMap = $this->getBrandSlugIdMap();

        foreach ($productInfoArray as $productInfo) {
            $product = $this->productRepository->create([
                'category_id' => $productInfo['category_id'],
                'brand_id' => $brandSlugIdMap[$productInfo['brand_slug']],
                'name' => $productInfo['name'],
                'slug' => $productInfo['slug'],
                'price' => mt_rand(1, 9) * 10 + mt_rand(1, 9) * 100 + mt_rand(0, 1) * 1000,
                'discount_percent' => mt_rand(1, 3) * 10,
                'quantity' => 1000,
                'warranty_period' => 24,
                'description' => 'None',
                'main_image_path' => Config::FOLDER_PATH_PRODUCT_IMAGES . '/' . $productInfo['slug'] . '.jpg',
                'delete_flag' => false,
            ]);
            $this->createProductImages($product->id, $productInfo['slug']);
        }
    }

    private function createProductImages($productId, $productSlug)
    {
        $this->productRepository->createProductImage([
            'product_id' => $productId,
            'image_path' => Config::FOLDER_PATH_PRODUCT_IMAGES . '/' . $productSlug . '.jpg',
        ]);
        $this->productRepository->createProductImage([
            'product_id' => $productId,
            'image_path' => Config::FOLDER_PATH_PRODUCT_IMAGES . '/' . $productSlug . '-1.jpg',
        ]);
        $this->productRepository->createProductImage([
            'product_id' => $productId,
            'image_path' => Config::FOLDER_PATH_PRODUCT_IMAGES . '/' . $productSlug . '-2.jpg',
        ]);
        $this->productRepository->createProductImage([
            'product_id' => $productId,
            'image_path' => Config::FOLDER_PATH_PRODUCT_IMAGES . '/' . $productSlug . '-3.jpg',
        ]);
    }
}
