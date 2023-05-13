<?php

namespace App\Http\Requests;

use App\DataFilterConstants\OrderSearchOptionConstants;
use Illuminate\Validation\Rule;

class OrderSearchRequest extends BaseSearchRequest
{
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
                Rule::in(OrderSearchOptionConstants::toArray()),
            ],
        ];
    }
}
