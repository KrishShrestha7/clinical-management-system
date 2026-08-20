<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('98########'),
            'date_of_birth' => fake()->date(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'address' => fake()->address(),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->numerify('98########'),
            'blood_group' => fake()->randomElement([
                'A+',
                'A-',
                'B+',
                'B-',
                'O+',
                'O-',
                'AB+',
                'AB-',
            ]),
        ];
    }
}
