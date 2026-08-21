@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            {{-- Page Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2>Edit Patient</h2>

                    <p class="text-muted mb-0">
                        Patient ID: #{{ $patient->id }}
                    </p>

                </div>

                <a
                    href="{{ route('patients.show', $patient) }}"
                    class="btn btn-secondary"
                >
                    Back to Patient
                </a>

            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())

                <div class="alert alert-danger">

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- Edit Form --}}
            <div class="card">

                <div class="card-body">

                    <form
                        method="POST"
                        action="{{ route('patients.update', $patient) }}"
                    >

                        @csrf

                        @method('PUT')

                        {{-- Basic Information --}}

                        <h5 class="mb-3">
                            Basic Information
                        </h5>

                        <div class="row">

                            {{-- Name --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="name"
                                    class="form-label"
                                >
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $patient->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    required
                                >

                                @error('name')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="email"
                                    class="form-label"
                                >
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $patient->email) }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    required
                                >

                                @error('email')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        <div class="row">

                            {{-- Phone --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="phone"
                                    class="form-label"
                                >
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $patient->phone) }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    required
                                >

                                @error('phone')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- Date of Birth --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="date_of_birth"
                                    class="form-label"
                                >
                                    Date of Birth
                                </label>

                                <input
                                    type="date"
                                    id="date_of_birth"
                                    name="date_of_birth"
                                    value="{{ old('date_of_birth', optional($patient->date_of_birth)->format('Y-m-d')) }}"
                                    class="form-control @error('date_of_birth') is-invalid @enderror"
                                    required
                                >

                                @error('date_of_birth')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        <div class="row">

                            {{-- Gender --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="gender"
                                    class="form-label"
                                >
                                    Gender
                                </label>

                                <select
                                    id="gender"
                                    name="gender"
                                    class="form-select @error('gender') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        Select Gender
                                    </option>

                                    <option
                                        value="Male"
                                        {{ old('gender', $patient->gender) === 'Male' ? 'selected' : '' }}
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        {{ old('gender', $patient->gender) === 'Female' ? 'selected' : '' }}
                                    >
                                        Female
                                    </option>

                                    <option
                                        value="Other"
                                        {{ old('gender', $patient->gender) === 'Other' ? 'selected' : '' }}
                                    >
                                        Other
                                    </option>

                                </select>

                                @error('gender')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- Blood Group --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="blood_group"
                                    class="form-label"
                                >
                                    Blood Group
                                </label>

                                <select
                                    id="blood_group"
                                    name="blood_group"
                                    class="form-select @error('blood_group') is-invalid @enderror"
                                >

                                    <option value="">
                                        Select Blood Group
                                    </option>

                                    @foreach ([
                                        'A+',
                                        'A-',
                                        'B+',
                                        'B-',
                                        'AB+',
                                        'AB-',
                                        'O+',
                                        'O-'
                                    ] as $bloodGroup)

                                        <option
                                            value="{{ $bloodGroup }}"
                                            {{ old('blood_group', $patient->blood_group) === $bloodGroup ? 'selected' : '' }}
                                        >
                                            {{ $bloodGroup }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('blood_group')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        {{-- Address --}}

                        <h5 class="mb-3 mt-3">
                            Address
                        </h5>

                        <div class="mb-3">

                            <label
                                for="address"
                                class="form-label"
                            >
                                Address
                            </label>

                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                class="form-control @error('address') is-invalid @enderror"
                                required
                            >{{ old('address', $patient->address) }}</textarea>

                            @error('address')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        {{-- Emergency Contact --}}

                        <h5 class="mb-3 mt-4">
                            Emergency Contact
                        </h5>

                        <div class="row">

                            {{-- Contact Name --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="emergency_contact_name"
                                    class="form-label"
                                >
                                    Contact Name
                                </label>

                                <input
                                    type="text"
                                    id="emergency_contact_name"
                                    name="emergency_contact_name"
                                    value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                    class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                    required
                                >

                                @error('emergency_contact_name')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                            {{-- Contact Phone --}}
                            <div class="col-md-6 mb-3">

                                <label
                                    for="emergency_contact_phone"
                                    class="form-label"
                                >
                                    Contact Phone
                                </label>

                                <input
                                    type="text"
                                    id="emergency_contact_phone"
                                    name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                    class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                    required
                                >

                                @error('emergency_contact_phone')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                        {{-- Form Actions --}}

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('patients.show', $patient) }}"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Update Patient
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
