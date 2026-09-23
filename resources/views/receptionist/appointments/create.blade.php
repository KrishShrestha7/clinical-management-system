@extends('layouts.app')

@section('title', 'Create Appointment')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Create Appointment</h2>

            <p class="text-muted mb-0">
                Schedule an appointment on behalf of a patient.
            </p>
        </div>

        <a
            href="{{ route('receptionist.appointments.index') }}"
            class="btn btn-secondary"
        >
            Back to Appointments
        </a>

    </div>


    {{-- Error Message --}}
    @if (session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('receptionist.appointments.store') }}"
            >

                @csrf


                {{-- Patient --}}
                <div class="mb-3">

                    <label
                        for="patient_id"
                        class="form-label"
                    >
                        Patient
                    </label>

                    <select
                        id="patient_id"
                        name="patient_id"
                        class="form-select @error('patient_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Select Patient
                        </option>

                        @foreach ($patients as $patient)

                            <option
                                value="{{ $patient->id }}"
                                @selected(old('patient_id') == $patient->id)
                            >
                                {{ $patient->name }}
                                -
                                {{ $patient->email }}
                            </option>

                        @endforeach

                    </select>

                    @error('patient_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Doctor --}}
                <div class="mb-3">

                    <label
                        for="doctor_id"
                        class="form-label"
                    >
                        Doctor
                    </label>

                    <select
                        id="doctor_id"
                        name="doctor_id"
                        class="form-select @error('doctor_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Select Doctor
                        </option>

                        @foreach ($doctors as $doctor)

                            <option
                                value="{{ $doctor->id }}"
                                @selected(old('doctor_id') == $doctor->id)
                            >
                                {{ $doctor->user->name }}
                                -
                                {{ $doctor->employee_id }}
                            </option>

                        @endforeach

                    </select>

                    @error('doctor_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Date & Time --}}
                <div class="mb-3">

                    <label
                        for="scheduled_at"
                        class="form-label"
                    >
                        Appointment Date & Time
                    </label>

                    <input
                        type="datetime-local"
                        id="scheduled_at"
                        name="scheduled_at"
                        value="{{ old('scheduled_at') }}"
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        class="form-control @error('scheduled_at') is-invalid @enderror"
                        required
                    >

                    @error('scheduled_at')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Reason --}}
                <div class="mb-4">

                    <label
                        for="reason"
                        class="form-label"
                    >
                        Reason for Appointment
                    </label>

                    <textarea
                        id="reason"
                        name="reason"
                        rows="4"
                        class="form-control @error('reason') is-invalid @enderror"
                        placeholder="Enter the reason for the appointment"
                        required
                    >{{ old('reason') }}</textarea>

                    @error('reason')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="alert alert-info">

                    The appointment will initially be created as
                    <strong>Pending</strong>.

                </div>


                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create Appointment
                    </button>

                    <a
                        href="{{ route('receptionist.appointments.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
