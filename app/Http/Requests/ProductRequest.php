<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $productId = $this->route('productId');
        $isUpdateProductRequest = isset($productId);

        return [
            'categoryId' => ['required', Rule::exists('categories', 'id')->where('delete_flag', false)],
            'brandId' => ['required', Rule::exists('brands', 'id')->where('delete_flag', false)],
            'name' => 'required|max:128',
            'price' => 'required|min:0',
            'discountPercent' => 'required|min:0|max:99',
            'quantity' => 'required|min:0',
            'warrantyPeriod' => 'required|min:0|max:120',
            'description' => '',
            'mainImage' => ['mimes:jpeg,jpg,png', Rule::requiredIf(!$isUpdateProductRequest)],
        ];
    }
}
