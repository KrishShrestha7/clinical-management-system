@extends('layouts.app')

@section('title', 'Set Password')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm">

                <div class="card-body p-4">

                    <h3 class="mb-3">
                        Set Your Password
                    </h3>

                    <p class="text-muted">
                        Create a secure password for your staff account.
                    </p>


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


                    <form
                        method="POST"
                        action="{{ route('password.update') }}"
                    >

                        @csrf


                        {{-- Reset Token --}}
                        <input
                            type="hidden"
                            name="token"
                            value="{{ $token }}"
                        >


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
                                value="{{ old('email', $email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                readonly
                                required
                            >

                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Password --}}
                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label"
                            >
                                New Password
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            >

                            <div class="form-text">
                                Minimum 8 characters with uppercase,
                                lowercase, number, and special character.
                            </div>

                            @error('password')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Password Confirmation --}}
                        <div class="mb-4">

                            <label
                                for="password_confirmation"
                                class="form-label"
                            >
                                Confirm Password
                            </label>

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Set Password
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
