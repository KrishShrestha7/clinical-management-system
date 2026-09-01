<?php

namespace App\Services;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register a new user.
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => UserRole::PATIENT->value,
        ]);

            return $user;
    }

    /**
     * Authenticate a user.
     */
    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    /**
     * Authenticate a user without creating a web session.
     */
    public function authenticate(array $credentials): ?User
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return null;
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    /**
     * Log out the authenticated user.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
