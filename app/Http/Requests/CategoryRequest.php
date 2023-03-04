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

        return [
            'parentId' => [
                $this->parentId !== Constants::NONE_VALUE
                    ? Rule::exists('categories', 'id')->where('delete_flag', false)
                    : ''
            ],
            'name' => [
                'required', 'max:64',
                $isUpdateCategoryRequest
                    ? Rule::unique('categories', 'name')->where('delete_flag', false)->ignore($categoryId)
                    : Rule::unique('categories', 'name')->where('delete_flag', false)
            ],
            'icon' => ['mimes:jpeg,jpg,png'],
        ];
    }
}
