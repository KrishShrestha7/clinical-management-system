@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">
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

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>My Patient Profile</h2>

                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('patient-profile.edit') }}"
                            class="btn btn-primary"
                        >
                            Edit Profile
                        </a>

                        <a
                            href="{{ route('dashboard') }}"
                            class="btn btn-secondary"
                        >
                            Back to Dashboard
                        </a>

                    </div>

            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <h5 class="mb-3">
                        Basic Information
                    </h5>

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <strong>Name:</strong>
                            <p>{{ $patient->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Email:</strong>
                            <p>{{ $patient->email }}</p>
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <strong>Phone:</strong>
                            <p>{{ $patient->phone }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Date of Birth:</strong>
                            <p>{{ $patient->date_of_birth->format('Y-m-d') }}</p>
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <strong>Gender:</strong>
                            <p>{{ $patient->gender }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Blood Group:</strong>
                            <p>{{ $patient->blood_group ?? 'Not provided' }}</p>
                        </div>

                    </div>

                    <hr>

                    <h5 class="mb-3">
                        Address
                    </h5>

                    <p>{{ $patient->address }}</p>

                    <hr>

                    <h5 class="mb-3">
                        Emergency Contact
                    </h5>

                    <div class="row">

                        <div class="col-md-6">
                            <strong>Contact Name:</strong>
                            <p>{{ $patient->emergency_contact_name }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Contact Phone:</strong>
                            <p>{{ $patient->emergency_contact_phone }}</p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
