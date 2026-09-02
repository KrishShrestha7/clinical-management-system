@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')

<div class="container mt-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Patient Details</h2>

            <p class="text-muted mb-0">
                Patient ID: #{{ $patient->id }}
            </p>
        </div>

        <div class="d-flex gap-2">

            @can('update', $patient)

                <a
                    href="{{ route('patients.edit', $patient) }}"
                    class="btn btn-warning"
                >
                    Edit Patient
                </a>

            @endcan

            <a
                href="{{ route('patients.index') }}"
                class="btn btn-secondary"
            >
                Back to Patients
            </a>

        </div>

    </div>

    {{-- Success Message --}}
    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    {{-- Patient Information --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Personal Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Full Name</strong>

                    <p class="mb-0">
                        {{ $patient->name }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Email</strong>

                    <p class="mb-0">
                        {{ $patient->email ?? 'Not provided' }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Phone</strong>

                    <p class="mb-0">
                        {{ $patient->phone }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Date of Birth</strong>

                    <p class="mb-0">
                        {{ $patient->date_of_birth?->format('F d, Y') ?? 'Not provided' }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Gender</strong>

                    <p class="mb-0">
                        {{ $patient->gender?->value ?? 'Not provided' }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Blood Group</strong>

                    <p class="mb-0">
                        {{ $patient->blood_group ?? 'Not provided' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Address --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Address
            </h5>

        </div>

        <div class="card-body">

            <p class="mb-0">
                {{ $patient->address ?? 'Not provided' }}
            </p>

        </div>

    </div>

    {{-- Emergency Contact --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Emergency Contact
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <strong>Contact Name</strong>

                    <p class="mb-0">
                        {{ $patient->emergency_contact_name ?? 'Not provided' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <strong>Contact Phone</strong>

                    <p class="mb-0">
                        {{ $patient->emergency_contact_phone ?? 'Not provided' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- Actions --}}
    <div class="card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <span class="text-muted">
                    Patient created:
                    {{ $patient->created_at->format('F d, Y h:i A') }}
                </span>

                @can('delete', $patient)

                    <form
                        action="{{ route('patients.destroy', $patient) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this patient?')"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            Delete Patient
                        </button>

                    </form>

                @endcan

            </div>

        </div>

    </div>

</div>

@endsection
