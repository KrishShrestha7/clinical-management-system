<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'date_of_birth' => [
                'required',
                'date',
                'before:today',
            ],

            'gender' => [
                'required',
                Rule::enum(Gender::class),
            ],

            'role' => [
                'required',
                Rule::in([
                    UserRole::DOCTOR->value,
                    UserRole::RECEPTIONIST->value,
                ]),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
