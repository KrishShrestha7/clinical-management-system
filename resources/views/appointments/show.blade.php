@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h3 class="mb-0">
                            Appointment Details
                        </h3>

                        @switch($appointment->status->value)

                            @case('pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>
                                @break

                            @case('confirmed')
                                <span class="badge bg-primary">
                                    Confirmed
                                </span>
                                @break

                            @case('completed')
                                <span class="badge bg-success">
                                    Completed
                                </span>
                                @break

                            @case('cancelled')
                                <span class="badge bg-danger">
                                    Cancelled
                                </span>
                                @break

                        @endswitch

                    </div>


                    <div class="mb-3">

                        <strong>Doctor:</strong>

                        {{ $appointment->doctor->user->name }}

                    </div>


                    <div class="mb-3">

                        <strong>Employee ID:</strong>

                        {{ $appointment->doctor->employee_id }}

                    </div>


                    <div class="mb-3">

                        <strong>Date & Time:</strong>

                        {{ $appointment->scheduled_at->format('M d, Y h:i A') }}

                    </div>


                    <div class="mb-3">

                        <strong>Reason:</strong>

                        <p class="mt-2 mb-0">
                            {{ $appointment->reason }}
                        </p>

                    </div>


                    @if ($appointment->notes)

                        <div class="mb-3">

                            <strong>Notes:</strong>

                            <p class="mt-2 mb-0">
                                {{ $appointment->notes }}
                            </p>

                        </div>

                    @endif


                    <div class="mb-4">

                        <strong>Requested By:</strong>

                        {{ $appointment->creator?->name ?? 'Unknown' }}

                    </div>


                    <a
                        href="{{ route('appointments.index') }}"
                        class="btn btn-secondary"
                    >
                        Back to My Appointments
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
