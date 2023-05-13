<?php

namespace App\Http\Requests;

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
        ];
    }
}
