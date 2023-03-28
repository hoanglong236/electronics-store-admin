<?php

namespace App\Http\Requests;

use App\DataFilterConstants\ProductSearchOptionConstants;
use Illuminate\Validation\Rule;

class ProductSearchRequest extends BaseSearchRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'searchKeyword' => 'max:64',
            'searchOption' => [
                'required',
                Rule::in(ProductSearchOptionConstants::toArray()),
            ]
        ];
    }
}
