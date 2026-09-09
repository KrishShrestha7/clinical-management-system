@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Patient Details</h2>

            <p class="text-muted mb-0">
                {{ $patient->name }}
            </p>
        </div>

        <a
            href="{{ route('admin.patients.index') }}"
            class="btn btn-secondary"
        >
            Back to Patients
        </a>

    </div>


    {{-- Basic Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Basic Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Name</strong>

                    <p class="mb-0">
                        {{ $patient->name }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Email</strong>

                    <p class="mb-0">
                        {{ $patient->email ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Phone</strong>

                    <p class="mb-0">
                        {{ $patient->phone ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Date of Birth</strong>

                    <p class="mb-0">

                        @if ($patient->date_of_birth)

                            {{ $patient->date_of_birth->format('Y-m-d') }}

                        @else

                            Not provided

                        @endif

                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Gender</strong>

                    <p class="mb-0">

                        @if ($patient->gender)

                            {{ $patient->gender->value }}

                        @else

                            Not provided

                        @endif

                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Blood Group</strong>

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


    {{-- Account Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Account Information
            </h5>
        </div>

        <div class="card-body">

            @if ($patient->user)

                <p>
                    <strong>User Email:</strong>
                    {{ $patient->user->email }}
                </p>

                <p class="mb-0">
                    <strong>Role:</strong>
                    {{ ucfirst($patient->user->role->value) }}
                </p>

            @else

                <p class="text-muted mb-0">
                    No linked user account.
                </p>

            @endif

        </div>

    </div>


    {{-- Order Summary --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Orders
            </h5>

        </div>

        <div class="card-body">

            @if ($patient->orders->isEmpty())

                <p class="text-muted mb-0">
                    This patient has not placed any orders.
                </p>

            @else

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Order Number</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($patient->orders as $order)

                                <tr>

                                    <td>
                                        {{ $order->order_number }}
                                    </td>

                                    <td>

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

                                    </td>

                                    <td>
                                        Rs. {{ number_format(
                                            (float) $order->total_amount,
                                            2
                                        ) }}
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('Y-m-d') }}
                                    </td>

                                    <td>

                                        <a
                                            href="{{ route(
                                                'admin.orders.show',
                                                $order
                                            ) }}"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            View
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>


    {{-- Prescription Summary --}}
    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Prescriptions
            </h5>

        </div>

        <div class="card-body">

            @if ($patient->prescriptions->isEmpty())

                <p class="text-muted mb-0">
                    No prescriptions uploaded.
                </p>

            @else

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Medicine</th>
                                <th>Status</th>
                                <th>Uploaded</th>
                                <th>File</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($patient->prescriptions as $prescription)

                                <tr>

                                    <td>
                                        {{ $prescription->medicine->name }}
                                    </td>

                                    <td>

                                        @if ($prescription->status->value === 'approved')

                                            <span class="badge bg-success">
                                                Approved
                                            </span>

                                        @elseif ($prescription->status->value === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif ($prescription->status->value === 'rejected')

                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $prescription->created_at->format('Y-m-d H:i') }}
                                    </td>

                                    <td>

                                        <a
                                            href="{{ asset(
                                                'storage/' . $prescription->file_path
                                            ) }}"
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            View File
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
