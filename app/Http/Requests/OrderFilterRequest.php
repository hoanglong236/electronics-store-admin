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
            'emailKeyword' => 'max:64',
            'statusFilter' => [
                'required',
                Rule::in(OrderFilterRequestConstants::statusArray())
            ],
            'paymentMethodFilter' => [
                'required',
                Rule::in(OrderFilterRequestConstants::paymentMethodArray())
            ],
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate'
        ];
    }

    /**
     * Override the default.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'orderIdKeyword' => $this->orderIdKeyword ?? '',
            'emailKeyword' => $this->emailKeyword ?? '',
        ]);
    }
}
