<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to checkout.
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
        return [];
    }
}
