<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on the authenticated user's role.
     */
    public function index(): View
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => view('dashboard.admin'),
            'doctor' => view('dashboard.doctor'),
            'receptionist' => view('dashboard.receptionist'),
            'patient' => view('dashboard.patient'),
            default => abort(403, 'Unauthorized role.'),
        };
    }
}
