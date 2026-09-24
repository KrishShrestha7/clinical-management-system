@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('content')

<div class="container mt-4">

    {{-- Header --}}
    <div class="mb-4">

        <h2>Receptionist Dashboard</h2>

        <p class="text-muted mb-0">
            Welcome, {{ auth()->user()->name }}.
        </p>

    </div>


    {{-- Statistics --}}
    <div class="row">

        {{-- Total Patients --}}
        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Patients
                    </h6>

                    <h3>
                        {{ $totalPatients }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Today's Appointments --}}
        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Today's Appointments
                    </h6>

                    <h3>
                        {{ $todayAppointments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Pending Appointments --}}
        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Appointments
                    </h6>

                    <h3>
                        {{ $pendingAppointments }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    <div class="row">

        {{-- Confirmed Appointments --}}
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Confirmed Appointments
                    </h6>

                    <h3>
                        {{ $confirmedAppointments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Completed Appointments --}}
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Completed Appointments
                    </h6>

                    <h3>
                        {{ $completedAppointments }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Quick Actions --}}
    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Quick Actions
            </h5>

        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <a
                    href="{{ route('patients.index') }}"
                    class="btn btn-primary"
                >
                    Manage Patients
                </a>


                <a
                    href="{{ route('receptionist.appointments.index') }}"
                    class="btn btn-outline-primary"
                >
                    Manage Appointments
                </a>


                <a
                    href="{{ route('receptionist.appointments.create') }}"
                    class="btn btn-outline-success"
                >
                    Create Appointment
                </a>

                <a
                    href="{{ route('receptionist.orders.index') }}"
                    class="btn btn-outline-secondary"
                >
                    View Orders
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
