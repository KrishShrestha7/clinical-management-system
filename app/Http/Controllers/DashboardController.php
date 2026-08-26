<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Enums\UserRole;
class DashboardController extends Controller
{
    /**
     * Display the dashboard based on the authenticated user's role.
     */
    public function index(): View
    {
        $user = auth()->user();

        return match ($user->role) {
            UserRole::ADMIN => view('dashboard.admin'),
            UserRole::DOCTOR => view('dashboard.doctor'),
            UserRole::RECEPTIONIST => view('dashboard.receptionist'),
            UserRole::PATIENT => view('dashboard.patient'),
            default => abort(403, 'Unauthorized role.'),
        };
    }
}
