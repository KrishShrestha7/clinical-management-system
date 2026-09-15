@extends('layouts.app')

@section('title', 'Edit Staff')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Edit Staff</h2>

            <p class="text-muted mb-0">
                {{ $staff->employee_id }}
            </p>
        </div>

        <a
            href="{{ route('admin.staff.show', $staff) }}"
            class="btn btn-secondary"
        >
            Back to Staff Details
        </a>

    </div>


    @if (session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


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
                action="{{ route('admin.staff.update', $staff) }}"
            >

                @csrf
                @method('PUT')


                {{-- Employee ID --}}
                <div class="mb-3">

                    <label class="form-label">
                        Employee ID
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $staff->employee_id }}"
                        readonly
                    >

                    <div class="form-text">
                        Employee ID cannot be changed.
                    </div>

                </div>


                {{-- Name --}}
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $staff->user->name) }}"
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
                <div class="mb-3">

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
                        value="{{ old('email', $staff->user->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        required
                    >

                    @error('email')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="row">

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
                            value="{{ old(
                                'date_of_birth',
                                $staff->user->date_of_birth?->format('Y-m-d')
                            ) }}"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            required
                        >

                        @error('date_of_birth')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


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

                            @foreach (\App\Enums\Gender::cases() as $gender)

                                <option
                                    value="{{ $gender->value }}"
                                    @selected(
                                        old(
                                            'gender',
                                            $staff->user->gender?->value
                                        ) === $gender->value
                                    )
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

                </div>


                {{-- Role --}}
                <div class="mb-3">

                    <label
                        for="role"
                        class="form-label"
                    >
                        Staff Role
                    </label>

                    <select
                        id="role"
                        name="role"
                        class="form-select @error('role') is-invalid @enderror"
                        required
                    >

                        <option
                            value="{{ \App\Enums\UserRole::DOCTOR->value }}"
                            @selected(
                                old(
                                    'role',
                                    $staff->user->role->value
                                )
                                === \App\Enums\UserRole::DOCTOR->value
                            )
                        >
                            Doctor
                        </option>

                        <option
                            value="{{ \App\Enums\UserRole::RECEPTIONIST->value }}"
                            @selected(
                                old(
                                    'role',
                                    $staff->user->role->value
                                )
                                === \App\Enums\UserRole::RECEPTIONIST->value
                            )
                        >
                            Receptionist
                        </option>

                    </select>

                    @error('role')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Phone --}}
                <div class="mb-3">

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
                        value="{{ old('phone', $staff->phone) }}"
                        class="form-control @error('phone') is-invalid @enderror"
                    >

                    @error('phone')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Address --}}
                <div class="mb-4">

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
                    >{{ old('address', $staff->address) }}</textarea>

                    @error('address')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <div class="alert alert-info">

                    Password changes are handled separately through
                    the password setup/reset process.

                </div>


                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Staff
                    </button>

                    <a
                        href="{{ route('admin.staff.show', $staff) }}"
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
