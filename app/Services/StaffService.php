<?php

namespace App\Services;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Notifications\StaffAccountCreated;
use Illuminate\Support\Facades\Password;

class StaffService
{
    public function create(array $data): Staff
    {
        $staff = DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'password' => Hash::make(Str::random(40)),
                'role' => $data['role'],
            ]);

            return Staff::create([
                'user_id' => $user->id,
                'employee_id' => $this->generateEmployeeId(),
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);
        });

        $staff->load('user');

        $this->sendPasswordSetupLink($staff);

        return $staff;
    }

    public function update(Staff $staff, array $data): Staff
    {
        return DB::transaction(function () use ($staff, $data) {

            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'date_of_birth' => $data['date_of_birth'],
                'gender' => $data['gender'],
                'role' => $data['role'],
            ];

            $staff->user->update($userData);

            $staff->update([
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
            ]);

            return $staff->fresh('user');
        });
    }

    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Staff::query()
            ->with('user')
            ->latest()
            ->paginate($perPage);
    }

    public function sendPasswordSetupLink(Staff $staff): void
    {
        $staff->loadMissing('user');

        Password::broker()->sendResetLink(
            [
                'email' => $staff->user->email,
            ],
            function ($user, $token) use ($staff) {

                $resetUrl = route('password.reset', [
                    'token' => $token,
                    'email' => $user->email,
                ]);

                $user->notify(
                    new StaffAccountCreated(
                        $staff->employee_id,
                        $user->role->value,
                        $resetUrl
                    )
                );
            }
        );
    }

    private function generateEmployeeId(): string
    {
        return 'EMP-' . Str::upper((string) Str::ulid());
    }
}
