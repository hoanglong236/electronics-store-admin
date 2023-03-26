<?php

namespace App\Http\Requests;

use App\ModelConstants\OrderStatusConstants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class OrderStatusRequest extends FormRequest
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
        return [
            'status' => [
                'required',
                Rule::in(OrderStatusConstants::toArray()),
            ],
        ];
    }

    /**
     * Override the default
     */
    protected function failedValidation(Validator $validator)
    {
        $orderId = $this->route('orderId');
        Session::flash('orderId', $orderId);

        parent::failedValidation($validator);
    }
}
