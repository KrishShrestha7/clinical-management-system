@extends('layouts.app')

@section('title', 'Complete Patient Profile')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>Complete Your Patient Profile</h2>

                <a
                    href="{{ route('dashboard') }}"
                    class="btn btn-secondary"
                >
                    Back to Dashboard
                </a>

            </div>

            @if (session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif

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

            <div class="card">

                <div class="card-body">

                    <form
                        method="POST"
                        action="{{ route('patient-profile.store') }}"
                    >

                        @csrf

                        <h5 class="mb-3">
                            Account Information
                        </h5>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ auth()->user()->name }}"
                                    disabled
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    value="{{ auth()->user()->email }}"
                                    disabled
                                >

                            </div>

                        </div>

                        <h5 class="mb-3 mt-3">
                            Personal Information
                        </h5>

                        <div class="row">

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
                                    value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    required
                                >

                                @error('phone')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

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
                                    value="{{ old('date_of_birth') }}"
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

                                    @foreach (\App\Enums\Gender::cases() as $gender)

                                        <option
                                            value="{{ $gender->value }}"
                                            {{ old('gender') === $gender->value ? 'selected' : '' }}
                                        >
                                            {{ $gender->value }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('gender')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

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
                                            {{ old('blood_group') === $bloodGroup ? 'selected' : '' }}
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
                            >{{ old('address') }}</textarea>

                            @error('address')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <h5 class="mb-3 mt-4">
                            Emergency Contact
                        </h5>

                        <div class="row">

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
                                    value="{{ old('emergency_contact_name') }}"
                                    class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                    required
                                >

                                @error('emergency_contact_name')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

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
                                    value="{{ old('emergency_contact_phone') }}"
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

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('dashboard') }}"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Complete Profile
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
