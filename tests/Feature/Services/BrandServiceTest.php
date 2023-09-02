<?php

namespace Tests\Feature\Services;

use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class BrandServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $brandService;

    private function allTestSetup(): void
    {
        $this->brandService = app(BrandService::class);
    }

    public function test_it_should_be_get_brand_by_id(): void
    {
        // Setup
        $this->allTestSetup();
        $brandSetup = Brand::factory()->create();

        // Run
        $brand = $this->brandService->getBrandById($brandSetup->id);

        // Asserts
        $this->assertEquals($brandSetup->attributesToArray(), $brand->attributesToArray());
    }

    public function test_it_should_not_be_get_brand_by_not_existed_id(): void
    {
        // Setup
        $this->allTestSetup();
        $brandSetup = Brand::factory()->create();
        $notExistedId = $brandSetup->id + mt_rand(1, 999);

        // Run
        $brand = $this->brandService->getBrandById($notExistedId);

        // Asserts
        $this->assertNull($brand);
    }

    public function test_brands_should_be_paginated(): void
    {
        // Setup
        $this->allTestSetup();
        $totalItem = 10;
        Brand::factory()->count($totalItem)->create();
        $itemPerPageSetup = mt_rand(3, 4);

        // Run
        $paginator = $this->brandService->getBrandsPaginator($itemPerPageSetup);

        // Asserts
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals($itemPerPageSetup, $paginator->perPage());
        $this->assertEquals($totalItem, $paginator->total());
    }

    public function test_it_should_be_returned_zero_items_paginator_when_there_is_no_brand(): void
    {
        // Setup
        $this->allTestSetup();
        $itemPerPageSetup = 5;

        // Run
        $paginator = $this->brandService->getBrandsPaginator($itemPerPageSetup);

        // Asserts
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals($itemPerPageSetup, $paginator->perPage());
        $this->assertEquals(0, $paginator->total());
    }

    public function test_searched_brands_should_be_paginated(): void
    {
        // Setup
        $this->allTestSetup();
        Brand::factory()->create(['name' => 'Banana', 'slug' => 'banana']);
        Brand::factory()->create(['name' => 'Banana1', 'slug' => 'banana-1']);
        Brand::factory()->create(['name' => 'Banana2', 'slug' => 'banana-2']);
        Brand::factory()->create(['name' => 'Apple', 'slug' => 'apple']);
        Brand::factory()->create(['name' => 'Apple1', 'slug' => 'apple-1']);
        Brand::factory()->create(['name' => 'Apple2', 'slug' => 'apple-2']);

        $itemPerPageSetup = 2;
        $searchProps1 = [];
        $searchProps1['searchKeyword'] = 'apple';
        $searchProps2 = [];
        $searchProps2['searchKeyword'] = 'banana1';

        // Run
        $paginator1 = $this->brandService->getSearchBrandsPaginator($searchProps1, $itemPerPageSetup);
        $paginator2 = $this->brandService->getSearchBrandsPaginator($searchProps2, $itemPerPageSetup);

        // Asserts
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator1);
        $this->assertEquals($itemPerPageSetup, $paginator1->perPage());
        $this->assertEquals(3, $paginator1->total());

        $this->assertEquals($itemPerPageSetup, $paginator2->perPage());
        $this->assertEquals(1, $paginator2->total());
    }

    public function test_it_should_be_returned_zero_items_paginator_when_search_condition_not_match(): void
    {
        // Setup
        $this->allTestSetup();
        Brand::factory()->create(['name' => 'Banana', 'slug' => 'banana']);
        Brand::factory()->create(['name' => 'Banana1', 'slug' => 'banana-1']);
        Brand::factory()->create(['name' => 'Apple', 'slug' => 'apple']);
        Brand::factory()->create(['name' => 'Apple1', 'slug' => 'apple-1']);

        $itemPerPageSetup = 2;
        $searchProps = [];
        $searchProps['searchKeyword'] = 'cherry';

        // Run
        $paginator = $this->brandService->getSearchBrandsPaginator($searchProps, $itemPerPageSetup);

        // Asserts
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals($itemPerPageSetup, $paginator->perPage());
        $this->assertEquals(0, $paginator->total());
    }

    public function test_brand_should_be_created(): void
    {
        // Setup
        $this->allTestSetup();
        $createProps = [];
        $createProps['name'] = 'Banana';
        $createProps['slug'] = 'banana';
        $createProps['logo'] = UploadedFile::fake()->image('banana.png');
        $createProps['delete_flag'] = false;

        // Run
        $brand = $this->brandService->createBrand($createProps);

        // Asserts
        $this->assertDatabaseHas('brands', [
            'name' => $createProps['name'],
            'slug' => $createProps['slug'],
            'delete_flag' => false,
        ]);

        $brandLogoPath = public_path('storage') . "\\" . $brand->logo_path;
        $this->assertTrue(file_exists($brandLogoPath));

        // Clean up
        unlink($brandLogoPath);
    }

    public function test_brand_should_be_updated(): void
    {
        // Setup
        $this->allTestSetup();
        $brandSetup = Brand::factory()->create([
            'name' => 'Brand',
            'slug' => 'brand',
        ]);
        $updateProps = [];
        $updateProps['name'] = 'New brand';
        $updateProps['slug'] = 'new-brand';
        $updateProps['logo'] = UploadedFile::fake()->image('new-brand.png');

        // Run
        $updatedBrand = $this->brandService->updateBrand($updateProps, $brandSetup->id);

        // Asserts
        $this->assertDatabaseMissing('brands', [
            'name' => $brandSetup->name,
            'slug' => $brandSetup->slug,
        ]);
        $this->assertDatabaseHas('brands', [
            'name' => $updateProps['name'],
            'slug' => $updateProps['slug'],
        ]);

        $newBrandLogoPath = public_path('storage') . "\\" . $updatedBrand->logo_path;
        $this->assertTrue(file_exists($newBrandLogoPath));

        // Clean up
        unlink($newBrandLogoPath);
    }

    public function test_brand_should_be_deleted(): void
    {
        // Setup
        $this->allTestSetup();
        $brandSetup = Brand::factory()->create();

        // Run
        $deletedBrand = $this->brandService->deleteBrandById($brandSetup->id);

        // Asserts
        $this->assertTrue($deletedBrand->delete_flag);
    }

    public function test_it_should_be_returned_map_from_brand_id_to_brand(): void
    {
        // Setup
        $this->allTestSetup();
        Brand::factory()->count(2)->create();
        $deletedBrand = Brand::factory()->create(['delete_flag' => true]);

        // Run
        $map1 = $this->brandService->getMapFromBrandIdToBrand();
        $map2 = $this->brandService->getMapFromBrandIdToBrand(true);

        // Asserts
        $this->assertEquals(count($map1), 2);
        $this->assertArrayNotHasKey($deletedBrand->id, $map1);

        $this->assertEquals(count($map2), 3);
        $this->assertArrayHasKey($deletedBrand->id, $map2);
    }

    public function test_it_should_be_returned_empty_map_when_there_is_no_brand(): void
    {
        // Setup
        $this->allTestSetup();

        // Run
        $map = $this->brandService->getMapFromBrandIdToBrand();

        // Asserts
        $this->assertEmpty($map);
    }
}
