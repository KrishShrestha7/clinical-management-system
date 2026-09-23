<?php

namespace App\Http\Controllers\Receptionist;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        $totalPatients = Patient::count();

        $todayAppointments = Appointment::query()
            ->whereDate('scheduled_at', $today)
            ->count();

        $pendingAppointments = Appointment::query()
            ->where(
                'status',
                AppointmentStatus::PENDING->value
            )
            ->count();

        $confirmedAppointments = Appointment::query()
            ->where(
                'status',
                AppointmentStatus::CONFIRMED->value
            )
            ->count();

        $completedAppointments = Appointment::query()
            ->where(
                'status',
                AppointmentStatus::COMPLETED->value
            )
            ->count();

        return view(
            'receptionist.dashboard',
            compact(
                'totalPatients',
                'todayAppointments',
                'pendingAppointments',
                'confirmedAppointments',
                'completedAppointments'
            )
        );
    }
}
