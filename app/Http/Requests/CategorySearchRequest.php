<?php

namespace App\Http\Requests;

use App\DataFilterConstants\CategorySearchOptionConstants;
use Illuminate\Validation\Rule;

class CategorySearchRequest extends BaseSearchRequest
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
                Rule::in(CategorySearchOptionConstants::toArray()),
            ]
        ];
    }
}
