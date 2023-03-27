<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Override the default
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'searchKeyword' => $this->searchKeyword ?? '',
        ]);
    }
}
