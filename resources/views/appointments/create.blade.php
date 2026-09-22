@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h3 class="mb-4">
                        Book Appointment
                    </h3>

                    @if ($errors->has('appointment'))
                        <div class="alert alert-danger">
                            {{ $errors->first('appointment') }}
                        </div>
                    @endif


                    <form
                        method="POST"
                        action="{{ route('appointments.store') }}"
                    >

                        @csrf


                        {{-- Doctor --}}
                        <div class="mb-3">

                            <label
                                for="doctor_id"
                                class="form-label"
                            >
                                Select Doctor
                            </label>

                            <select
                                id="doctor_id"
                                name="doctor_id"
                                class="form-select @error('doctor_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Choose a doctor
                                </option>

                                @foreach ($doctors as $doctor)

                                    <option
                                        value="{{ $doctor->id }}"
                                        @selected(old('doctor_id') == $doctor->id)
                                    >
                                        {{ $doctor->user->name }}
                                        - {{ $doctor->employee_id }}
                                    </option>

                                @endforeach

                            </select>

                            @error('doctor_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Date and Time --}}
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
                                required
                            >{{ old('reason') }}</textarea>

                            @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Request Appointment
                            </button>

                            <a
                                href="{{ route('appointments.index') }}"
                                class="btn btn-secondary"
                            >
                                Cancel
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
