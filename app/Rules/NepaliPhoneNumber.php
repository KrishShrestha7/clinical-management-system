<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NepaliPhoneNumber implements ValidationRule
{
    /**
     * Validate a Nepali mobile phone number.
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        if (!is_string($value) || !preg_match('/^(96|97|98)\d{8}$/', $value)) {
            $fail('The :attribute must be a valid 10-digit Nepali mobile number.');
        }
    }
}