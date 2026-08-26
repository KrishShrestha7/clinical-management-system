@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')

<div class="container mt-5">

    <h2>Patient Dashboard</h2>

    <p class="text-muted">
        Welcome, {{ auth()->user()->name }}.
    </p>

    <div class="row mt-4">

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    @if (auth()->user()->patient)

                        <h5>My Profile</h5>

                        <p>
                            View your patient profile information.
                        </p>

                        <a
                            href="{{ route('patient-profile.show') }}"
                            class="btn btn-primary"
                        >
                            My Profile
                        </a>

                    @else

                        <h5>Complete Profile</h5>

                        <p>
                            Complete your patient information before using all patient services.
                        </p>

                        <a
                            href="{{ route('patient-profile.create') }}"
                            class="btn btn-primary"
                        >
                            Complete Profile
                        </a>

                    @endif

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>My Appointments</h5>

                    <p>
                        View your upcoming appointments.
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>Medicines</h5>

                    <p>
                        Browse medicines available for ordering.
                    </p>

                    <a
                        href="{{ route('medicines.catalog') }}"
                        class="btn btn-primary"
                    >
                        Browse Medicines
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5>My Orders</h5>

                    <p>
                        View your medicine order history.
                    </p>

                    <a
                        href="{{ route('orders.index') }}"
                        class="btn btn-primary"
                    >
                        View Orders
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
