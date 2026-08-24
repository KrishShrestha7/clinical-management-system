<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use throwable;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        try {
            $this->authService->register(
                $request->validated()
            );

            $request->session()->regenerate();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Registration successful.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $credentials = $request->validated();

            if (!$this->authService->login($credentials)) {
                return back()
                    ->withErrors([
                        'email' => 'The provided credentials are incorrect.',
                    ])
                    ->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(
                route('dashboard')
            );
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Login failed. Please try again.');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        try {
            $this->authService->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('success', 'You have been logged out.');
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('dashboard')
                ->with('error', 'Logout failed. Please try again.');
        }
    }
}
