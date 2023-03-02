<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Common\Constants;

class BrandService
{
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
            $brand->logo_path = $updateBrandProperties['logoPath'];
        }

        $brand->update();
    }

    public function deleteBrand($brandId) {
        $brand = $this->findBrandById($brandId);

        $brand->delete_flag = true;
        $brand->update();

        Storage::delete(Constants::BRAND_LOGO_STORAGE_PATH . $brand->logo_path);
    }
}
