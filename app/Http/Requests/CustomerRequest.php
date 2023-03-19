<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Validation\Validator;

class CustomerRequest extends FormRequest
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
            'disableFlag' => 'required|boolean',
        ];
    }

    /**
     * Override the default
     */
    public function messages()
    {
        return [
            'disableFlag.*' => 'Something went wrong with this action.',
        ];
    }

    /**
     * Override the default
     */
    protected function failedValidation(Validator $validator)
    {
        $customerId = $this->route('customerId');
        Session::flash('customerId', $customerId);

        parent::failedValidation($validator);
    }

    /**
     * Override the default
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'disableFlag' => $this->toBoolean($this->disableFlag),
        ]);
    }

    private function toBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
