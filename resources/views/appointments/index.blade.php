@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            My Appointments
        </h2>

        <a
            href="{{ route('appointments.create') }}"
            class="btn btn-primary"
        >
            Book Appointment
        </a>

    </div>


    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if ($appointments->count())

        <div class="card shadow-sm">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>
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

                                <td>
                                    {{ $appointment->doctor->user->name }}
                                </td>

                                <td>
                                    {{ $appointment->scheduled_at->format('M d, Y h:i A') }}
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($appointment->reason, 50) }}
                                </td>

                                <td>

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

                                </td>

                                <td>

                                    <a
                                        href="{{ route('appointments.show', $appointment) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        <div class="mt-3">
            {{ $appointments->links() }}
        </div>

    @else

        <div class="alert alert-info">

            You do not have any appointments yet.

            <a href="{{ route('appointments.create') }}">
                Book your first appointment
            </a>.

        </div>

    @endif

</div>

@endsection
