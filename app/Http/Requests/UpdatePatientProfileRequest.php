<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Gender;
use Illuminate\Validation\Rule;

class UpdatePatientProfileRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isPatient()
            && $this->user()?->patient !== null;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'date_of_birth' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'gender' => [
                'required',
                Rule::enum(Gender::class),
            ],

            'blood_group' => [
                'nullable',
                'in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            ],

            'address' => [
                'required',
                'string',
                'max:500',
            ],

            'emergency_contact_name' => [
                'required',
                'string',
                'max:255',
            ],

            'emergency_contact_phone' => [
                'required',
                'string',
                'max:20',
            ],
        ];
    }
}
