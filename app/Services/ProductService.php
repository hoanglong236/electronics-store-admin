<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductService
{
    public function findProductById($productId) {
        return Product::where(['id' => $productId, 'delete_flag' => false])->first();
    }

    public function listProductsPaginate($itemPerPage = 9) {
        return Product::where('delete_flag', false)->paginate($itemPerPage);
    }

    public function createProduct($productPropterties) {
        $product = new Product();

        $product->category_id = $productPropterties['categoryId'];
        $product->brand_id = $productPropterties['brandId'];
        $product->name = $productPropterties['name'];
        $product->main_image_path = $productPropterties['mainImagePath'];
        $product->delete_flag = false;

        $product->save();
    }

    public function updateProduct($productPropterties, $productId) {
        $product = $this->findProductById($productId);

        $product->category_id = $productPropterties['categoryId'];
        $product->brand_id = $productPropterties['brandId'];
        $product->name = $productPropterties['name'];
        if (isset($productPropterties['mainImagePath'])) {
            $product->main_image_path = $productPropterties['mainImagePath'];
        }

        $product->update();
    }

    public function deleteProduct($productId) {
        $product = $this->findProductById($productId);

        $product->delete_flag = true;
        $product->update();
    }
}
