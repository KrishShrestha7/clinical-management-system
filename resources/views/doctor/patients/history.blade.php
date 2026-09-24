@extends('layouts.app')

@section('title', 'Patient Clinical History')

@section('content')

<div class="container mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>
                Patient Clinical History
            </h2>

            <p class="text-muted mb-0">
                {{ $patient->name }}
            </p>

        </div>

        <a
            href="{{ route(
                'doctor.appointments.show',
                $appointment
            ) }}"
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

                <div class="col-md-4 mb-3">

                    <strong>
                        Name
                    </strong>

                    <p class="mb-0">
                        {{ $patient->name }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

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


                <div class="col-md-4 mb-3">

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


                <div class="col-md-4 mb-3">

                    <strong>
                        Blood Group
                    </strong>

                    <p class="mb-0">
                        {{ $patient->blood_group ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Phone
                    </strong>

                    <p class="mb-0">
                        {{ $patient->phone ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Email
                    </strong>

                    <p class="mb-0">
                        {{ $patient->email ?? 'Not provided' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Appointment History --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Appointment History
            </h5>

        </div>

        <div class="card-body">

            @if ($appointments->isEmpty())

                <p class="text-muted mb-0">
                    No appointment history is available.
                </p>

            @else

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Date & Time</th>
                                <th>Doctor</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($appointments as $appointmentItem)

                                <tr>

                                    <td>
                                        {{ $appointmentItem->scheduled_at->format(
                                            'M d, Y h:i A'
                                        ) }}
                                    </td>


                                    <td>
                                        {{ $appointmentItem->doctor->user->name }}
                                    </td>


                                    <td>
                                        {{ \Illuminate\Support\Str::limit(
                                            $appointmentItem->reason,
                                            60
                                        ) }}
                                    </td>


                                    <td>

                                        @if (
                                            $appointmentItem->status->value === 'pending'
                                        )

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif (
                                            $appointmentItem->status->value === 'confirmed'
                                        )

                                            <span class="badge bg-primary">
                                                Confirmed
                                            </span>

                                        @elseif (
                                            $appointmentItem->status->value === 'completed'
                                        )

                                            <span class="badge bg-success">
                                                Completed
                                            </span>

                                        @elseif (
                                            $appointmentItem->status->value === 'cancelled'
                                        )

                                            <span class="badge bg-danger">
                                                Cancelled
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst(
                                                    $appointmentItem->status->value
                                                ) }}
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>


    {{-- Prescription History --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Prescription History
            </h5>

        </div>

        <div class="card-body">

            @if ($prescriptions->isEmpty())

                <p class="text-muted mb-0">
                    No prescriptions are available.
                </p>

            @else

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Medicine</th>
                                <th>Status</th>
                                <th>Uploaded</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($prescriptions as $prescription)

                                <tr>

                                    <td>
                                        {{ $prescription->medicine->name }}
                                    </td>


                                    <td>

                                        @if (
                                            $prescription->status->value === 'pending'
                                        )

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif (
                                            $prescription->status->value === 'approved'
                                        )

                                            <span class="badge bg-success">
                                                Approved
                                            </span>

                                        @elseif (
                                            $prescription->status->value === 'rejected'
                                        )

                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst(
                                                    $prescription->status->value
                                                ) }}
                                            </span>

                                        @endif

                                    </td>


                                    <td>
                                        {{ $prescription->created_at->format(
                                            'M d, Y h:i A'
                                        ) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>


    {{-- Medication / Order History --}}
    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Medication / Order History
            </h5>

        </div>

        <div class="card-body">

            @if ($orders->isEmpty())

                <p class="text-muted mb-0">
                    No medication orders are available.
                </p>

            @else

                @foreach ($orders as $order)

                    <div class="border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between mb-3">

                            <div>

                                <strong>
                                    Order {{ $order->order_number }}
                                </strong>

                                <div class="text-muted small">
                                    {{ $order->created_at->format(
                                        'M d, Y h:i A'
                                    ) }}
                                </div>

                            </div>


                            <div>

                                @if ($order->status === 'paid')

                                    <span class="badge bg-success">
                                        Paid
                                    </span>

                                @elseif ($order->status === 'pending')

                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ ucfirst($order->status) }}
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="table-responsive">

                            <table class="table table-sm align-middle mb-0">

                                <thead>

                                    <tr>
                                        <th>Medicine</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th class="text-end">
                                            Line Total
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($order->items as $item)

                                        <tr>

                                            <td>
                                                {{ $item->medicine_name }}
                                            </td>

                                            <td>
                                                Rs. {{ number_format(
                                                    (float) $item->unit_price,
                                                    2
                                                ) }}
                                            </td>

                                            <td>
                                                {{ $item->quantity }}
                                            </td>

                                            <td class="text-end">
                                                Rs. {{ number_format(
                                                    (float) $item->line_total,
                                                    2
                                                ) }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>


                        <div class="text-end mt-3">

                            <strong>
                                Order Total:
                                Rs. {{ number_format(
                                    (float) $order->total_amount,
                                    2
                                ) }}
                            </strong>

                        </div>

                    </div>

                @endforeach

            @endif

        </div>

    </div>

</div>

@endsection
