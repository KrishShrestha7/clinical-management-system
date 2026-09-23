@extends('layouts.app')

@section('title', 'Manage Appointments')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Manage Appointments</h2>

            <p class="text-muted mb-0">
                Review and manage patient appointments.
            </p>
        </div>

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-secondary"
        >
            Back to Dashboard
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


    @if ($appointments->isEmpty())

        <div class="alert alert-info">
            No appointments have been scheduled.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date & Time</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($appointments as $appointment)

                                <tr>

                                    {{-- Patient --}}
                                    <td>
                                        <strong>
                                            {{ $appointment->patient->name }}
                                        </strong>
                                    </td>


                                    {{-- Doctor --}}
                                    <td>
                                        {{ $appointment->doctor->user->name }}
                                    </td>


                                    {{-- Date & Time --}}
                                    <td>

                                        {{ $appointment->scheduled_at->format(
                                            'M d, Y h:i A'
                                        ) }}

                                    </td>


                                    {{-- Reason --}}
                                    <td>

                                        {{ \Illuminate\Support\Str::limit(
                                            $appointment->reason,
                                            50
                                        ) }}

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if (
                                            $appointment->status->value === 'pending'
                                        )

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif (
                                            $appointment->status->value === 'confirmed'
                                        )

                                            <span class="badge bg-primary">
                                                Confirmed
                                            </span>

                                        @elseif (
                                            $appointment->status->value === 'completed'
                                        )

                                            <span class="badge bg-success">
                                                Completed
                                            </span>

                                        @elseif (
                                            $appointment->status->value === 'cancelled'
                                        )

                                            <span class="badge bg-danger">
                                                Cancelled
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst(
                                                    $appointment->status->value
                                                ) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="{{ route(
                                                    'receptionist.appointments.show',
                                                    $appointment
                                                ) }}"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                View
                                            </a>


                                            @if (
                                                $appointment->status->value === 'pending'
                                            )

                                                <form
                                                    method="POST"
                                                    action="{{ route(
                                                        'receptionist.appointments.confirm',
                                                        $appointment
                                                    ) }}"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-success btn-sm"
                                                    >
                                                        Confirm
                                                    </button>

                                                </form>

                                            @endif


                                            @if (
                                                in_array(
                                                    $appointment->status->value,
                                                    ['pending', 'confirmed']
                                                )
                                            )

                                                <form
                                                    method="POST"
                                                    action="{{ route(
                                                        'receptionist.appointments.cancel',
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
                                                        class="btn btn-danger btn-sm"
                                                    >
                                                        Cancel
                                                    </button>

                                                </form>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Pagination --}}
        <div class="mt-3">

            {{ $appointments->links() }}

        </div>

    @endif

</div>

@endsection
