<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'email',
                'max:255',
                // Ignore the current customer's own email when checking uniqueness
                Rule::unique('customers', 'email')->ignore($this->route('customer')),
            ],
            'phone'   => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'notes'   => ['nullable', 'string', 'max:2000'],
        ];
    }
}
