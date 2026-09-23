@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')

<div class="container mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>
                Appointment Details
            </h2>

            <p class="text-muted mb-0">
                Appointment #{{ $appointment->id }}
            </p>

        </div>

        <a
            href="{{ route('doctor.appointments.index') }}"
            class="btn btn-secondary"
        >
            Back to My Appointments
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


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

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


                {{-- Requested On --}}
                <div class="col-md-4 mb-3">

                    <strong>
                        Requested On
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


                <div class="col-md-6 mb-3">

                    <strong>
                        Gender
                    </strong>

                    <p class="mb-0">

                        @if ($appointment->patient->gender)

                            {{ $appointment->patient->gender->value }}

                        @else

                            Not provided

                        @endif

                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Blood Group
                    </strong>

                    <p class="mb-0">
                        {{ $appointment->patient->blood_group ?? 'Not provided' }}
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


    {{-- Appointment Notes --}}
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


    {{-- Appointment Actions --}}
    @if (
        in_array(
            $appointment->status->value,
            ['pending', 'confirmed']
        )
    )

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Appointment Actions
                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex flex-wrap gap-2">

                    {{-- View Patient --}}
                    <a
                        href="{{ route(
                            'doctor.appointments.patient',
                            $appointment
                        ) }}"
                        class="btn btn-outline-primary"
                    >
                        View Patient
                    </a>


                    {{-- Complete Appointment --}}
                    @if ($appointment->status->value === 'confirmed')

                        <form
                            method="POST"
                            action="{{ route(
                                'doctor.appointments.complete',
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

        </div>


    @elseif ($appointment->status->value === 'completed')

        <div class="card shadow-sm">

            <div class="card-header">

                <h5 class="mb-0">
                    Appointment Actions
                </h5>

            </div>

            <div class="card-body">

                <div class="d-flex flex-wrap gap-2">

                    <a
                        href="{{ route(
                            'doctor.appointments.patient',
                            $appointment
                        ) }}"
                        class="btn btn-outline-primary"
                    >
                        View Patient
                    </a>

                    <span class="alert alert-success mb-0 py-2">
                        This appointment has been completed.
                    </span>

                </div>

            </div>

        </div>


    @elseif ($appointment->status->value === 'pending')

        <div class="alert alert-warning">
            This appointment is still pending receptionist confirmation.
        </div>


    @elseif ($appointment->status->value === 'cancelled')

        <div class="alert alert-danger">
            This appointment has been cancelled.
        </div>

    @endif

</div>

@endsection
