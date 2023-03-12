<?php

namespace App\Services;

use App\Common\Constants;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandService
{
    private $storageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
    }

    public function findById($brandId)
    {
        return Brand::where(['id' => $brandId, 'delete_flag' => false])->first();
    }

    public function listBrands()
    {
        return Brand::where('delete_flag', false)->get();
    }

    public function createBrand($brandProperties)
    {
        $logoPath = $this->storageService->saveFile($brandProperties['logo'], Constants::BRAND_LOGO_PATH);

        Brand::create([
            'name' => $brandProperties['name'],
            'slug' => $brandProperties['slug'],
            'logo_path' => $logoPath,
            'delete_flag' => false,
        ]);
    }

    public function updateBrand($brandProperties, $brandId)
    {
        $brand = $this->findById($brandId);

        $brand->name = $brandProperties['name'];
        $brand->slug = $brandProperties['slug'];
        if (isset($brandProperties['logo'])) {
            $this->storageService->deleteFile($brand->logo_path);
            $brand->logo_path = $this->storageService->saveFile($brandProperties['logo'], Constants::BRAND_LOGO_PATH);
        }

        $brand->save();
    }

    public function deleteBrand($brandId)
    {
        $brand = $this->findById($brandId);
        $brand->delete_flag = true;

        $brand->save();
    }

    public function getBrandIdNameMap()
    {
        $brands = $this->listBrands();
        $map = [];
        foreach ($brands as $brand) {
            $map[$brand->id] = $brand->name;
        }

        return $map;
    }
}
