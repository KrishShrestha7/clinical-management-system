@extends('layouts.app')

@section('title', 'Patients')

@section('content')

<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>Patients</h2>

            <p class="text-muted mb-0">
                Manage registered patients
            </p>

        </div>

        <a
            href="{{ route('patients.create') }}"
            class="btn btn-primary"
        >
            Add Patient
        </a>

    </div>

    {{-- Success Message --}}
    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif

    {{-- Patients Table --}}
    <div class="card">

        <div class="card-body p-0">

            @if ($patients->count())

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>ID</th>

                                <th>Patient Name</th>

                                <th>Email</th>

                                <th>Phone</th>

                                <th>Gender</th>

                                <th>Blood Group</th>

                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($patients as $patient)

                                <tr>

                                    <td>
                                        #{{ $patient->id }}
                                    </td>

                                    <td>
                                        {{ $patient->name }}
                                    </td>

                                    <td>
                                        {{ $patient->email }}
                                    </td>

                                    <td>
                                        {{ $patient->phone }}
                                    </td>

                                    <td>
                                        {{ $patient->gender?->value ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $patient->blood_group ?? 'N/A' }}
                                    </td>

                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="{{ route('patients.show', $patient) }}"
                                                class="btn btn-sm btn-info"
                                            >
                                                View
                                            </a>

                                            @can('update', $patient)

                                                <a
                                                    href="{{ route('patients.edit', $patient) }}"
                                                    class="btn btn-sm btn-warning"
                                                >
                                                    Edit
                                                </a>

                                            @endcan

                                            @can('delete', $patient)

                                                <form
                                                    method="POST"
                                                    action="{{ route('patients.destroy', $patient) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this patient?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger"
                                                    >
                                                        Delete
                                                    </button>

                                                </form>

                                            @endcan

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center p-5">

                    <h5>
                        No patients found
                    </h5>

                    <p class="text-muted">
                        There are currently no registered patients.
                    </p>

                    <a
                        href="{{ route('patients.create') }}"
                        class="btn btn-primary"
                    >
                        Add First Patient
                    </a>

                </div>

            @endif

        </div>

    </div>

    {{-- Pagination --}}
    @if ($patients->hasPages())

        <div class="mt-4">

            {{ $patients->links() }}

        </div>

    @endif

</div>

@endsection
