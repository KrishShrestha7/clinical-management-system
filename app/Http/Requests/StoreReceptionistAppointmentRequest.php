<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceptionistAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isReceptionist() ?? false;
    }

    public function rules(): array
    {
        return [
            'patient_id' => [
                'required',
                'integer',
                'exists:patients,id',
            ],

            'doctor_id' => [
                'required',
                'integer',
                'exists:staff,id',
            ],

            'scheduled_at' => [
                'required',
                'date',
                'after:now',
            ],

            'reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Please select a patient.',
            'patient_id.exists' => 'The selected patient is invalid.',

            'doctor_id.required' => 'Please select a doctor.',
            'doctor_id.exists' => 'The selected doctor is invalid.',

            'scheduled_at.required' => 'Please select an appointment date and time.',
            'scheduled_at.after' => 'The appointment must be scheduled for a future date and time.',

            'reason.required' => 'Please provide a reason for the appointment.',
            'reason.max' => 'The appointment reason cannot exceed 1000 characters.',
        ];
    }
}
