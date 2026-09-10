<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
class DashboardController extends Controller
{
    /**
     * Display the dashboard based on the authenticated user's role.
     */
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        return match ($user->role) {
            UserRole::ADMIN => redirect()->route('dashboard.admin'),
            UserRole::DOCTOR => view('dashboard.doctor'),
            UserRole::RECEPTIONIST => view('dashboard.receptionist'),
            UserRole::PATIENT => view('dashboard.patient'),
            default => abort(403, 'Unauthorized role.'),
        };
    }
}
