@extends('layouts.app')

@section('title', 'Staff Details')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Staff Details</h2>

            <p class="text-muted mb-0">
                {{ $staff->employee_id }}
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.staff.edit', $staff) }}"
                class="btn btn-primary"
            >
                Edit Staff
            </a>

            <form
                action="{{ route('admin.staff.password-reset', $staff) }}"
                method="POST"
                class="d-inline"
            >
                @csrf

                <button
                    type="submit"
                    class="btn btn-warning"
                    onclick="return confirm('Send a new password setup/reset link to this staff member?')"
                >
                    Send Password Reset Link
                </button>
            </form>

            <a
                href="{{ route('admin.staff.index') }}"
                class="btn btn-secondary"
            >
                Back to Staff
            </a>

        </div>

    </div>


    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Account Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>
                        Employee ID
                    </strong>

                    <p class="mb-0">
                        {{ $staff->employee_id }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Name
                    </strong>

                    <p class="mb-0">
                        {{ $staff->user->name }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Email
                    </strong>

                    <p class="mb-0">
                        {{ $staff->user->email }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Role
                    </strong>

                    <p class="mb-0">

                        @if ($staff->user->role->value === 'doctor')

                            <span class="badge bg-primary">
                                Doctor
                            </span>

                        @elseif ($staff->user->role->value === 'receptionist')

                            <span class="badge bg-info text-dark">
                                Receptionist
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ ucfirst($staff->user->role->value) }}
                            </span>

                        @endif

                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>
                        Date of Birth
                    </strong>

                    <p class="mb-0">

                        @if ($staff->user->date_of_birth)

                            {{ $staff->user->date_of_birth->format('Y-m-d') }}

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

                        @if ($staff->user->gender)

                            {{ $staff->user->gender->value }}

                        @else

                            Not provided

                        @endif

                    </p>

                </div>

            </div>

        </div>

    </div>


    <div class="card shadow-sm">

        <div class="card-header">

            <h5 class="mb-0">
                Staff Information
            </h5>

        </div>

        <div class="card-body">

            <p>

                <strong>
                    Phone:
                </strong>

                {{ $staff->phone ?? 'Not provided' }}

            </p>

            <p class="mb-0">

                <strong>
                    Address:
                </strong>

                {{ $staff->address ?? 'Not provided' }}

            </p>

        </div>

    </div>

</div>

@endsection
