<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function findCategoryById($categoryId) {
        return Category::where(['id' => $categoryId, 'delete_flag' => false])->first();
    }

    public function listCategories() {
        return Category::where('delete_flag', false)->get();
    }

    public function createCategory($categoryProperties) {
        $category = new Category();

        $category->parent_id = $categoryProperties['parentId'];
        $category->name = $categoryProperties['name'];
        $category->delete_flag = false;

        $category->save();
    }

    public function updateCategory($categoryProperties, $categoryId) {
        $category = $this->findCategoryById($categoryId);

        $category->parent_id = $categoryProperties['parentId'];
        $category->name = $categoryProperties['name'];

        $category->update();
    }

    public function deleteCategory($categoryId) {
        $category = $this->findCategoryById($categoryId);

        $category->delete_flag = true;
        $category->update();
    }

    public function deleteCategoryTree($categoryId) {
        DB::statement(
            "WITH RECURSIVE category_tree AS (
                SELECT * FROM categories WHERE categories.id = ?
                UNION ALL
                SELECT categories.* FROM category_tree
                INNER JOIN categories ON categories.parent_id = category_tree.id
            )
            UPDATE categories SET deleted_flag = FALSE WHERE id IN (
                SELECT category_tree.id FROM category_tree
                WHERE category_tree.deleted_flag = FALSE
            )", [$categoryId]);
    }
}
