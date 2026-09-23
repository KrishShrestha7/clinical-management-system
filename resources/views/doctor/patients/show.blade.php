@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Patient Details</h2>

            <p class="text-muted mb-0">
                Patient: {{ $patient->name }}
            </p>
        </div>

        <a
            href="{{ route('doctor.appointments.show', $appointment) }}"
            class="btn btn-secondary"
        >
            Back to Appointment
        </a>

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
                        Full Name
                    </strong>

                    <p class="mb-0">
                        {{ $patient->name }}
                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Email
                    </strong>

                    <p class="mb-0">
                        {{ $patient->email ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Phone
                    </strong>

                    <p class="mb-0">
                        {{ $patient->phone ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-6 mb-3">

                    <strong>
                        Date of Birth
                    </strong>

                    <p class="mb-0">

                        @if ($patient->date_of_birth)

                            {{ $patient->date_of_birth->format('F d, Y') }}

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

                        @if ($patient->gender)

                            {{ $patient->gender->value }}

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
                        {{ $patient->blood_group ?? 'Not provided' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Contact Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Contact Information
            </h5>
        </div>

        <div class="card-body">

            <p>
                <strong>Address:</strong>
                {{ $patient->address ?? 'Not provided' }}
            </p>

            <p>
                <strong>Emergency Contact:</strong>
                {{ $patient->emergency_contact_name ?? 'Not provided' }}
            </p>

            <p class="mb-0">
                <strong>Emergency Phone:</strong>
                {{ $patient->emergency_contact_phone ?? 'Not provided' }}
            </p>

        </div>

    </div>


    {{-- Appointment Context --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">
                Appointment Context
            </h5>
        </div>

        <div class="card-body">

            <p>
                <strong>Appointment Date:</strong>
                {{ $appointment->scheduled_at->format('F d, Y h:i A') }}
            </p>

            <p class="mb-0">
                <strong>Reason:</strong>
                {{ $appointment->reason }}
            </p>

        </div>

    </div>

</div>

@endsection
