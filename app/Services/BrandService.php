<?php

namespace App\Services;

use App\Common\Constants;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;

class BrandService
{
    private $storageService;
    private $firebaseStorageService;

    public function __construct()
    {
        $this->storageService = new StorageService();
        $this->firebaseStorageService = new FirebaseStorageService();
    }

    public function findById($brandId)
    {
        return Brand::where(['id' => $brandId, 'delete_flag' => false])->first();
    }

    public function getListBrandsPaginator($limit = Constants::BASE_ITEM_PAGE_COUNT)
    {
        return Brand::where('delete_flag', false)
            ->latest()
            ->paginate($limit);
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
        $this->firebaseStorageService->uploadImage($logoPath);
    }

    public function updateBrand($brandProperties, $brandId)
    {
        $brand = $this->findById($brandId);

        $brand->name = $brandProperties['name'];
        $brand->slug = $brandProperties['slug'];

        if (isset($brandProperties['logo'])) {
            $this->storageService->deleteFile($brand->logo_path);
            $this->firebaseStorageService->deleteImage($brand->logo_path);

            $brand->logo_path = $this->storageService->saveFile(
                $brandProperties['logo'],
                Constants::BRAND_LOGO_PATH
            );
            $this->firebaseStorageService->uploadImage($brand->logo_path);
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

    public function getSearchBrandsPaginator($searchBrandProperties, $limit = Constants::BASE_ITEM_PAGE_COUNT)
    {
        $searchKeyword = $searchBrandProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return Brand::where('delete_flag', false)
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $escapedKeyword . '%');
            })
            ->latest()
            ->paginate($limit);
    }
}
