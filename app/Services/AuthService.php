<?php

namespace App\Services;

use App\Models\User;
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
            'role' => 'receptionist',
        ]);
            Auth::login($user);

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
     * Log out the authenticated user.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
