<?php

namespace App\Http\Requests;

use App\ModelConstants\CategoryConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategorySearchRequest extends FormRequest
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
            'searchKeyword' => 'max:64',
            'searchField' => [
                'required',
                Rule::in(CategoryConstants::toArray()),
            ]
        ];
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
