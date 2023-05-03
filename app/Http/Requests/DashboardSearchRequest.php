<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardSearchRequest extends FormRequest
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
            'fromDate' => 'bail|required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
        ];
    }

    public function messages()
    {
        return [
            'toDate.after_or_equal' => 'toDate must be after or equal to fromDate',
        ];
    }
}
