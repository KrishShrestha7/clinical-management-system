<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed test users for each application role.
     */
    public function run(): void
    {
        User::factory()
            ->admin()
            ->create([
                'name' => 'Test Admin',
                'email' => 'admin@clinic.test',
            ]);

        User::factory()
            ->doctor()
            ->create([
                'name' => 'Test Doctor',
                'email' => 'doctor@clinic.test',
            ]);

        User::factory()
            ->receptionist()
            ->create([
                'name' => 'Test Receptionist',
                'email' => 'receptionist@clinic.test',
            ]);

        User::factory()
            ->patient()
            ->create([
                'name' => 'Test Patient',
                'email' => 'patient@clinic.test',
            ]);
    }
}
