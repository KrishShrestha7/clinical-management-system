@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')

<div class="container mt-4">

    {{-- Header --}}
    <div class="mb-4">

        <h2>
            Doctor Dashboard
        </h2>

        <p class="text-muted mb-0">
            Welcome, {{ auth()->user()->name }}.
        </p>

    </div>


    {{-- Statistics --}}
    <div class="row">

        {{-- Today's Appointments --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Today's Appointments
                    </h6>

                    <h3 class="mb-0">
                        {{ $todayAppointments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Upcoming --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Upcoming Appointments
                    </h6>

                    <h3 class="mb-0">
                        {{ $upcomingAppointments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Pending --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Appointments
                    </h6>

                    <h3 class="mb-0">
                        {{ $pendingAppointments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Completed --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Completed Appointments
                    </h6>

                    <h3 class="mb-0">
                        {{ $completedAppointments }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Quick Actions --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Quick Actions
            </h5>

        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <a
                    href="{{ route('doctor.appointments.index') }}"
                    class="btn btn-primary"
                >
                    My Appointments
                </a>

            </div>

        </div>

    </div>


    {{-- Doctor Information --}}
    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Doctor Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>
                        Name
                    </strong>

                    <p class="mb-0">
                        {{ auth()->user()->name }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Email
                    </strong>

                    <p class="mb-0">
                        {{ auth()->user()->email }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Employee ID
                    </strong>

                    <p class="mb-0">
                        {{ auth()->user()->staff?->employee_id ?? 'Not available' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
