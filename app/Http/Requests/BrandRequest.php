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

        return [
            'name' => [
                'required', 'max:64',
                isset($brandId)
                    ? Rule::unique('brands', 'name')->where('delete_flag', false)->ignore($brandId)
                    : Rule::unique('brands', 'name')->where('delete_flag', false)
            ],
            'logo' => ['mimes:jpeg,jpg,png', Rule::requiredIf(!isset($brandId))],
        ];
    }
}
