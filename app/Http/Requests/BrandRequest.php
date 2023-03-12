<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
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
        $brandId = $this->route('brandId');
        $isUpdateBrandRequest = isset($brandId);

        $brandNameUniqueRule = Rule::unique('brands', 'name')->where('delete_flag', false);
        $brandSlugUniqueRule = Rule::unique('brands', 'slug')->where('delete_flag', false);

        return [
            'name' => [
                'required', 'max:45',
                $isUpdateBrandRequest ? $brandNameUniqueRule->ignore($brandId) : $brandNameUniqueRule
            ],
            'slug' => [
                'required', 'max:45',
                $isUpdateBrandRequest ? $brandSlugUniqueRule->ignore($brandId) : $brandSlugUniqueRule
            ],
            'logo' => ['mimes:jpeg,jpg,png', Rule::requiredIf(!$isUpdateBrandRequest)],
        ];
    }
}
