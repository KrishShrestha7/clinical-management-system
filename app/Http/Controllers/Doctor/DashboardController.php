<?php

namespace App\Http\Controllers\Doctor;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $doctor = auth()->user()->staff;

        if (!$doctor) {
            abort(403);
        }

        $today = Carbon::today();

        $todayAppointments = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('scheduled_at', $today)
            ->count();

        $upcomingAppointments = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->where('scheduled_at', '>', now())
            ->whereIn('status', [
                AppointmentStatus::PENDING->value,
                AppointmentStatus::CONFIRMED->value,
            ])
            ->count();

        $pendingAppointments = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->where(
                'status',
                AppointmentStatus::PENDING->value
            )
            ->count();

        $completedAppointments = Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->where(
                'status',
                AppointmentStatus::COMPLETED->value
            )
            ->count();

        return view(
            'doctor.dashboard',
            compact(
                'todayAppointments',
                'upcomingAppointments',
                'pendingAppointments',
                'completedAppointments'
            )
        );
    }
}
