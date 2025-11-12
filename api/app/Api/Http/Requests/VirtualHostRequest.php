<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VirtualHostRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'domain' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9.-]+$/',
                'max:255',
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'domain.required' => 'Domain name is required.',
            'domain.string'   => 'Domain must be a valid string.',
            'domain.regex'    => 'Domain may contain only letters, digits, dots, and hyphens.',
            'domain.max'      => 'Domain name must not exceed 255 characters.',
        ];
    }
}
