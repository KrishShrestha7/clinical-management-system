<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RescheduleAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isReceptionist() ?? false;
    }

    public function rules(): array
    {
        return [
            'scheduled_at' => [
                'required',
                'date',
                'after:now',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.required' => 'Please select a new appointment date and time.',
            'scheduled_at.after' => 'The new appointment time must be in the future.',
        ];
    }
}
