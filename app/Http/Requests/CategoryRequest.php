<?php

namespace App\Http\Requests;

use App\Common\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('categoryId');
        $isUpdateCategoryRequest = isset($categoryId);

        $categoryNameUniqueRule = Rule::unique('categories', 'name')->where('delete_flag', false);
        $categorySlugUniqueRule = Rule::unique('categories', 'slug')->where('delete_flag', false);

        $hasParentId = isset($this->parentId) && $this->parentId !== Constants::NONE_VALUE;

        return [
            'parentId' => [
                $hasParentId ? Rule::exists('categories', 'id')->where('delete_flag', false) : ''
            ],
            'name' => [
                'required', 'max:60',
                $isUpdateCategoryRequest ? $categoryNameUniqueRule->ignore($categoryId) : $categoryNameUniqueRule
            ],
            'slug' => [
                'required', 'max:60',
                $isUpdateCategoryRequest ? $categorySlugUniqueRule->ignore($categoryId) : $categorySlugUniqueRule
            ],
            'icon' => ['mimes:jpeg,jpg,png', Rule::requiredIf(!$isUpdateCategoryRequest)],
        ];
    }
}
