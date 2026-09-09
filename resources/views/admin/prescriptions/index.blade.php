@extends('layouts.app')

@section('title', 'Prescription Review')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Prescription Review</h2>

            <p class="text-muted mb-0">
                Review patient prescription uploads.
            </p>
        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="btn btn-secondary"
        >
            Back to Admin Dashboard
        </a>

    </div>


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


    @if ($prescriptions->isEmpty())

        <div class="alert alert-info">
            No prescriptions have been uploaded yet.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Patient</th>
                                <th>Medicine</th>
                                <th>Prescription</th>
                                <th>Status</th>
                                <th>Uploaded</th>
                                <th>Review</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($prescriptions as $prescription)

                                <tr>

                                    <td>
                                        {{ $prescription->patient->name }}
                                    </td>


                                    <td>
                                        {{ $prescription->medicine->name }}
                                    </td>


                                    <td>

                                        <a
                                            href="{{ asset('storage/' . $prescription->file_path) }}"
                                            target="_blank"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            View File
                                        </a>

                                    </td>


                                    <td>

                                        @if ($prescription->status->value === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif ($prescription->status->value === 'approved')

                                            <span class="badge bg-success">
                                                Approved
                                            </span>

                                        @elseif ($prescription->status->value === 'rejected')

                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>

                                        @endif

                                    </td>


                                    <td>
                                        {{ $prescription->created_at->format('Y-m-d H:i') }}
                                    </td>


                                    <td>

                                        @if ($prescription->status->value === 'pending')

                                            <div class="mb-2">

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.prescriptions.approve', $prescription) }}"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        class="btn btn-success btn-sm"
                                                    >
                                                        Approve
                                                    </button>

                                                </form>

                                            </div>


                                            <form
                                                method="POST"
                                                action="{{ route('admin.prescriptions.reject', $prescription) }}"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <div class="mb-2">

                                                    <input
                                                        type="text"
                                                        name="rejection_reason"
                                                        class="form-control form-control-sm"
                                                        placeholder="Reason for rejection"
                                                        required
                                                    >

                                                </div>

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    Reject
                                                </button>

                                            </form>

                                        @elseif ($prescription->status->value === 'approved')

                                            <p class="text-success mb-1">
                                                Approved
                                            </p>

                                            @if ($prescription->reviewer)

                                                <small class="text-muted">
                                                    By {{ $prescription->reviewer->name }}
                                                </small>

                                            @endif

                                        @elseif ($prescription->status->value === 'rejected')

                                            <p class="text-danger mb-1">
                                                Rejected
                                            </p>

                                            @if ($prescription->rejection_reason)

                                                <small class="text-muted">
                                                    {{ $prescription->rejection_reason }}
                                                </small>

                                            @endif

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <div class="mt-3">
            {{ $prescriptions->links() }}
        </div>

    @endif

</div>

@endsection
