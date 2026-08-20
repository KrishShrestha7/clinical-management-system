<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                Rule::unique('patients', 'email')->ignore($this->route('patient')),
            ],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'blood_group' => ['nullable', 'string', 'max:10'],
        ];
    }
}
