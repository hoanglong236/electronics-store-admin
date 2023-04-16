<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageRequest extends FormRequest
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
            'images' => 'required',
            'images.*' => 'mimes:jpeg,jpg,png',
        ];
    }

    /**
     * Override the default
     */
    public function messages()
    {
        return [
            'images.*.mimes' => 'File #:position is invalid. Upload files must be images.',
        ];
    }
}
