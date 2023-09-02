<?php

namespace Tests\Feature\Services;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $categoryService;

    private function allTestSetup(): void
    {
        $this->categoryService = app(CategoryService::class);
    }

    public function test_category_should_be_found_by_id(): void
    {
        // Setup
        $this->allTestSetup();
        $categorySetup = Category::factory()->create();

        // Run
        $category = $this->categoryService->getCategoryById($categorySetup->id);

        // Asserts
        $this->assertEquals($categorySetup->attributesToArray(), $category->attributesToArray());
    }

    public function test_category_should_not_be_found_when_id_not_exist(): void
    {
        // Setup
        $this->allTestSetup();
        $categorySetup = Category::factory()->create();
        $notExistedId = $categorySetup->id + mt_rand(1, 999);

        // Run
        $category = $this->categoryService->getCategoryById($notExistedId);

        // Asserts
        $this->assertNull($category);
    }

    public function test_categories_should_be_paginated(): void
    {
        // Setup
        $this->allTestSetup();
        $totalItem = 10;
        Category::factory()->count($totalItem)->create();
        $itemPerPageSetup = mt_rand(3, 4);

        // Run
        $paginator = $this->categoryService->getCategoriesPaginator($itemPerPageSetup);

        // Asserts
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals($itemPerPageSetup, $paginator->perPage());
        $this->assertEquals($totalItem, $paginator->total());
    }

    public function test_it_should_be_returned_zero_items_paginator_when_there_is_no_category(): void
    {
        // Setup
        $this->allTestSetup();
        $itemPerPageSetup = 5;

        // Run
        $paginator = $this->categoryService->getCategoriesPaginator($itemPerPageSetup);

        // Asserts
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals($itemPerPageSetup, $paginator->perPage());
        $this->assertEquals(0, $paginator->total());
    }

    public function test_searched_categories_should_be_paginated(): void
    {
        // Setup
        $this->allTestSetup();
        $phoneCategory = Category::factory()->create(['name' => 'Phone', 'slug' => 'phone']);
        Category::factory()->create(['name' => 'Phone1', 'slug' => 'phone-1']);
        Category::factory()->create([
            'parent_id' => $phoneCategory->id,
            'name' => 'Sub category 1',
            'slug' => 'sub-category-1',
        ]);
        Category::factory()->create(['name' => 'Laptop', 'slug' => 'laptop']);
        Category::factory()->create(['name' => 'Laptop1', 'slug' => 'laptop-1']);

        $itemPerPageSetup = 2;
        $searchProps1 = [];
        $searchProps1['searchKeyword'] = 'Phone';
        $searchProps2 = [];
        $searchProps2['searchKeyword'] = 'laptop-1';

        // Run
        $paginator1 = $this->categoryService->getSearchCategoriesPaginator($searchProps1, $itemPerPageSetup);
        $paginator2 = $this->categoryService->getSearchCategoriesPaginator($searchProps2, $itemPerPageSetup);

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
        Category::factory()->create(['name' => 'Phone', 'slug' => 'phone']);
        Category::factory()->create(['name' => 'Laptop', 'slug' => 'laptop']);

        $itemPerPageSetup = 2;
        $searchProps = [];
        $searchProps['searchKeyword'] = 'watch';

        // Run
        $paginator = $this->categoryService->getSearchCategoriesPaginator($searchProps, $itemPerPageSetup);

        // Asserts
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertEquals($itemPerPageSetup, $paginator->perPage());
        $this->assertEquals(0, $paginator->total());
    }

    public function test_category_should_be_created(): void
    {
        // Setup
        $this->allTestSetup();
        $categorySetup = Category::factory()->create();

        $createProps = [];
        $createProps['parentId'] = $categorySetup->id;
        $createProps['name'] = 'Phone';
        $createProps['slug'] = 'phone';
        $createProps['icon'] = UploadedFile::fake()->image('phone.png');

        // Run
        $category = $this->categoryService->createCategory($createProps);

        // Asserts
        $this->assertDatabaseHas('categories', [
            'name' => $createProps['name'],
            'slug' => $createProps['slug'],
            'delete_flag' => false,
        ]);

        $categoryIconPath = public_path('storage') . "\\" . $category->icon_path;
        $this->assertTrue(file_exists($categoryIconPath));

        // Clean up
        unlink($categoryIconPath);
    }

    public function test_category_should_be_updated(): void
    {
        // Setup
        $this->allTestSetup();
        $parentCategorySetup = Category::factory()->create(['name' => 'ExPhone', 'slug' => 'ex-phone']);
        $categorySetup = Category::factory()->create(['name' => 'Phone', 'slug' => 'phone']);

        $updateProps = [];
        $updateProps['parentId'] = $parentCategorySetup->id;
        $updateProps['name'] = 'Laptop';
        $updateProps['slug'] = 'laptop';
        $updateProps['icon'] = UploadedFile::fake()->image('laptop.png');

        // Run
        $updatedCategory = $this->categoryService->updateCategory($updateProps, $categorySetup->id);

        // Asserts
        $this->assertDatabaseMissing('categories', [
            'name' => $categorySetup->name,
            'slug' => $categorySetup->slug,
        ]);
        $this->assertDatabaseHas('categories', [
            'parent_id' => $updateProps['parentId'],
            'name' => $updateProps['name'],
            'slug' => $updateProps['slug'],
        ]);

        $newCategoryIconPath = public_path('storage') . "\\" . $updatedCategory->icon_path;
        $this->assertTrue(file_exists($newCategoryIconPath));

        // Clean up
        unlink($newCategoryIconPath);
    }

    public function test_category_should_be_deleted(): void
    {
        // Setup
        $this->allTestSetup();
        $categorySetup = Category::factory()->create();

        // Run
        $deletedCategory = $this->categoryService->deleteCategoryById($categorySetup->id);

        // Asserts
        $this->assertDatabaseHas('categories', [
            'id' => $categorySetup->id,
            'delete_flag' => true,
        ]);
        $this->assertTrue($deletedCategory->delete_flag);
    }

    public function test_it_should_be_returned_map_from_category_id_to_category(): void
    {
        // Setup
        $this->allTestSetup();
        Category::factory()->count(2)->create();
        $deletedCategory = Category::factory()->create(['delete_flag' => true]);

        // Run
        $map1 = $this->categoryService->getMapFromCategoryIdToCategory();
        $map2 = $this->categoryService->getMapFromCategoryIdToCategory(true);

        // Asserts
        $this->assertEquals(count($map1), 2);
        $this->assertArrayNotHasKey($deletedCategory->id, $map1);

        $this->assertEquals(count($map2), 3);
        $this->assertArrayHasKey($deletedCategory->id, $map2);
    }

    public function test_it_should_be_returned_empty_map_when_there_is_no_category(): void
    {
        // Setup
        $this->allTestSetup();

        // Run
        $map = $this->categoryService->getMapFromCategoryIdToCategory();

        // Asserts
        $this->assertEmpty($map);
    }
}
