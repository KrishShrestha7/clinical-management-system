@extends('layouts.app')

@section('title', 'Manage Patients')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Patients</h2>

            <p class="text-muted mb-0">
                View all registered patient profiles.
            </p>
        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="btn btn-secondary"
        >
            Back to Dashboard
        </a>

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


    @if ($patients->isEmpty())

        <div class="alert alert-info">
            No patient profiles are available.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($patients as $patient)

                                <tr>

                                    <td>
                                        <strong>
                                            {{ $patient->name }}
                                        </strong>
                                    </td>


                                    <td>
                                        {{ $patient->email ?? 'Not provided' }}
                                    </td>


                                    <td>
                                        {{ $patient->phone ?? 'Not provided' }}
                                    </td>


                                    <td>

                                        @if ($patient->date_of_birth)

                                            {{ $patient->date_of_birth->format('Y-m-d') }}

                                        @else

                                            <span class="text-muted">
                                                Not provided
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        @if ($patient->gender)

                                            {{ $patient->gender->value }}

                                        @else

                                            <span class="text-muted">
                                                Not provided
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        <a
                                            href="{{ route(
                                                'admin.patients.show',
                                                $patient
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

            </div>

        </div>


        <div class="mt-3">

            {{ $patients->links() }}

        </div>

    @endif

</div>

@endsection
