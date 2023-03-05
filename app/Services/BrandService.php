<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandService
{
    private $storageService;

    public function __construct() {
        $this->storageService = new StorageService();
    }

    public function findBrandById($brandId) {
        return Brand::where(['id' => $brandId, 'delete_flag' => false])->first();
    }

    public function listBrands() {
        return Brand::where('delete_flag', false)->get();
    }

    public function createBrand($createBrandProperties) {
        $brand = new Brand();

        $brand->name = $createBrandProperties['name'];
        $brand->logo_path = $createBrandProperties['logoPath'];
        $brand->delete_flag = false;

        $brand->save();
    }

    public function updateBrand($updateBrandProperties, $brandId) {
        $brand = $this->findBrandById($brandId);

        $brand->name = $updateBrandProperties['name'];
        if (isset($updateBrandProperties['logoPath'])) {
            $this->storageService->deleteFile($brand->logo_path);
            $brand->logo_path = $updateBrandProperties['logoPath'];
        }

        $brand->update();
    }

    public function deleteBrand($brandId) {
        $brand = $this->findBrandById($brandId);

        $this->storageService->deleteFile($brand->logo_path);
        $brand->delete_flag = true;

        $brand->update();
    }

    public function getBrandNameMap() {
        $brands = $this->listBrands();
        $brandNameMap = [];
        foreach ($brands as $brand) {
            $brandNameMap[$brand->id] = $brand->name;
        }

        return $brandNameMap;
    }
}
