<?php

namespace App\Http\Requests;

use App\Http\Requests\Constants\OrderFilterRequestConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderFilterRequest extends FormRequest
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
            'orderIdKeyword' => 'max:32',
            'phoneOrEmailKeyword' => 'max:64',
            'deliveryAddressKeyword' => 'max:64',
            'statusFilter' => [
                'required',
                Rule::in(OrderFilterRequestConstants::statusArray())
            ],
            'paymentMethodFilter' => [
                'required',
                Rule::in(OrderFilterRequestConstants::paymentMethodArray())
            ],
            'sortField' => [
                'required',
                Rule::in(OrderFilterRequestConstants::sortByArray())
            ],
        ];
    }

    /**
     * Override the default.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'orderIdKeyword' => $this->orderIdKeyword ?? '',
            'phoneOrEmailKeyword' => $this->phoneOrEmailKeyword ?? '',
            'deliveryAddressKeyword' => $this->deliveryAddressKeyword ?? '',
        ]);
    }
}
