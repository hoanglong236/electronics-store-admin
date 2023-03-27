<?php

namespace App\Http\Requests;

use App\ModelConstants\CustomerSearchOptionConstants;
use Illuminate\Validation\Rule;

class CustomerSearchRequest extends BaseSearchRequest
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
                Rule::in(CustomerSearchOptionConstants::toArray()),
            ]
        ];
    }
}
