@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')

<div class="container mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>Appointment Details</h2>

            <p class="text-muted mb-0">
                Appointment #{{ $appointment->id }}
            </p>

        </div>

        <a
            href="{{ route('admin.appointments.index') }}"
            class="btn btn-secondary"
        >
            Back to Appointments
        </a>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- Error Message --}}
    @if (session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    {{-- Appointment Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Appointment Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                {{-- Status --}}
                <div class="col-md-4 mb-3">

                    <strong>
                        Status
                    </strong>

                    <p class="mb-0">

                        @if ($appointment->status->value === 'pending')

                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                        @elseif ($appointment->status->value === 'confirmed')

                            <span class="badge bg-primary">
                                Confirmed
                            </span>

                        @elseif ($appointment->status->value === 'completed')

                            <span class="badge bg-success">
                                Completed
                            </span>

                        @elseif ($appointment->status->value === 'cancelled')

                            <span class="badge bg-danger">
                                Cancelled
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($appointment->status->value) }}
                            </span>

                        @endif

                    </p>

                </div>


                {{-- Date & Time --}}
                <div class="col-md-4 mb-3">

                    <strong>
                        Date & Time
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->scheduled_at->format('F d, Y h:i A') }}
                    </p>

                </div>


                {{-- Created On --}}
                <div class="col-md-4 mb-3">

                    <strong>
                        Created On
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->created_at->format('F d, Y h:i A') }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Patient Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Patient Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>
                        Name
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->patient->name }}
                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Email
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->patient->email ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Phone
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->patient->phone ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Date of Birth
                    </strong>

                    <p class="mb-0">

                        @if ($appointment->patient->date_of_birth)

                            {{ $appointment->patient->date_of_birth->format('Y-m-d') }}

                        @else

                            Not provided

                        @endif

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Doctor Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Doctor Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>
                        Doctor
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->doctor->user->name }}
                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Employee ID
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->doctor->employee_id }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Reason --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Reason for Appointment
            </h5>
        </div>

        <div class="card-body">

            <p class="mb-0">
                {{ $appointment->reason }}
            </p>

        </div>

    </div>


    {{-- Notes --}}
    @if ($appointment->notes)

        <div class="card shadow-sm mb-4">

            <div class="card-header">
                <h5 class="mb-0">
                    Appointment Notes
                </h5>
            </div>

            <div class="card-body">

                <p class="mb-0">
                    {{ $appointment->notes }}
                </p>

            </div>

        </div>

    @endif


    {{-- Created By --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Created By
            </h5>
        </div>

        <div class="card-body">

            <p class="mb-0">
                {{ $appointment->creator?->name ?? 'System' }}
            </p>

        </div>

    </div>


    {{-- Administrative Actions --}}
    @if (
        in_array(
            $appointment->status->value,
            ['pending', 'confirmed']
        )
    )

        <div class="card shadow-sm">

            <div class="card-header">
                <h5 class="mb-0">
                    Administrative Actions
                </h5>
            </div>

            <div class="card-body">

                {{-- Confirm / Cancel --}}
                <div class="d-flex flex-wrap gap-2">

                    @if ($appointment->status->value === 'pending')

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.appointments.confirm',
                                $appointment
                            ) }}"
                        >

                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Confirm Appointment
                            </button>

                        </form>

                    @endif


                    <form
                        method="POST"
                        action="{{ route(
                            'admin.appointments.cancel',
                            $appointment
                        ) }}"
                        onsubmit="return confirm(
                            'Are you sure you want to cancel this appointment?'
                        )"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            Cancel Appointment
                        </button>

                    </form>

                </div>


                {{-- Reschedule --}}
                <hr class="my-4">

                <h6 class="mb-3">
                    Reschedule Appointment
                </h6>

                <form
                    method="POST"
                    action="{{ route(
                        'admin.appointments.reschedule',
                        $appointment
                    ) }}"
                >

                    @csrf
                    @method('PATCH')

                    <div class="row align-items-end">

                        <div class="col-md-6">

                            <label
                                for="scheduled_at"
                                class="form-label"
                            >
                                New Date & Time
                            </label>

                            <input
                                type="datetime-local"
                                id="scheduled_at"
                                name="scheduled_at"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="col-md-3 mt-3 mt-md-0">

                            <button
                                type="submit"
                                class="btn btn-warning"
                            >
                                Reschedule
                            </button>

                        </div>

                    </div>

                </form>


                {{-- Complete --}}
                @if ($appointment->status->value === 'confirmed')

                    <hr class="my-4">

                    <form
                        method="POST"
                        action="{{ route(
                            'admin.appointments.complete',
                            $appointment
                        ) }}"
                        onsubmit="return confirm(
                            'Mark this appointment as completed?'
                        )"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            Mark Appointment as Completed
                        </button>

                    </form>

                @endif

            </div>

        </div>

    @elseif ($appointment->status->value === 'completed')

        <div class="alert alert-success">
            This appointment has been completed.
        </div>

    @elseif ($appointment->status->value === 'cancelled')

        <div class="alert alert-danger">
            This appointment has been cancelled.
        </div>

    @endif

</div>

@endsection
