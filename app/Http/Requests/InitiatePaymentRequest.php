<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitiatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isPatient()
            && $this->user()?->patient !== null;
    }

    public function rules(): array
    {
        return [
            'payment_method' => [
                'required',
                'string',
                'in:online',
            ],
        ];
    }
}
