@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Manage Staff</h2>

            <p class="text-muted mb-0">
                View and manage doctors and receptionists.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.staff.create') }}"
                class="btn btn-primary"
            >
                Add Staff
            </a>

            <a
                href="{{ route('admin.dashboard') }}"
                class="btn btn-secondary"
            >
                Back to Dashboard
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


    @if ($staffMembers->isEmpty())

        <div class="alert alert-info">
            No staff members have been added yet.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($staffMembers as $staff)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $staff->employee_id }}
                                        </strong>
                                    </td>


                                    <td>
                                        {{ $staff->user->name }}
                                    </td>


                                    <td>
                                        {{ $staff->user->email }}
                                    </td>


                                    <td>

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

                                    </td>


                                    <td>
                                        {{ $staff->phone ?? 'Not provided' }}
                                    </td>


                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="{{ route(
                                                    'admin.staff.show',
                                                    $staff
                                                ) }}"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route(
                                                    'admin.staff.edit',
                                                    $staff
                                                ) }}"
                                                class="btn btn-outline-secondary btn-sm"
                                            >
                                                Edit
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <div class="mt-3">

            {{ $staffMembers->links() }}

        </div>

    @endif

</div>

@endsection