<?php

namespace App\Http\Requests;

use App\DataFilterConstants\OrderPaymentFilterConstants;
use App\DataFilterConstants\OrderSearchOptionConstants;
use App\DataFilterConstants\OrderStatusFilterConstants;
use Illuminate\Validation\Rule;

class OrderFilterRequest extends BaseSearchRequest
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
            'statusFilter' => [
                'required',
                Rule::in(OrderStatusFilterConstants::toArray()),
            ],
            'paymentFilter' => [
                'required',
                Rule::in(OrderPaymentFilterConstants::toArray()),
            ],
        ];
    }
}
