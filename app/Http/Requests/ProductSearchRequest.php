<?php

namespace App\Http\Requests;

use App\Http\Requests\Constants\ProductSearchRequestConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Override the default.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'searchKeyword' => 'max:64',
            'searchOption' => [
                'required',
                Rule::in(ProductSearchRequestConstants::toArray()),
            ]
        ];
    }

    /**
     * Override the default.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'searchKeyword' => $this->searchKeyword ?? '',
        ]);
    }
}
