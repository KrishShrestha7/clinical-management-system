@extends('layouts.app')

@section('title', 'Medicine Catalog')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Medicine Catalog</h2>

            <p class="text-muted mb-0">
                Browse medicines currently available for ordering.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('cart.index') }}"
                class="btn btn-primary"
            >
                View Cart
            </a>

            <a
                href="{{ route('dashboard') }}"
                class="btn btn-secondary"
            >
                Back to Dashboard
            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


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


    @if ($medicines->isEmpty())

        <div class="alert alert-info">
            No medicines are currently available.
        </div>

    @else

        <div class="row">

            @foreach ($medicines as $medicine)

                @php
                    $latestPrescription =
                        $latestPrescriptions[$medicine->id] ?? null;
                @endphp

                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title">
                                {{ $medicine->name }}
                            </h5>


                            @if ($medicine->generic_name)

                                <p class="text-muted mb-2">
                                    {{ $medicine->generic_name }}
                                </p>

                            @endif


                            <p class="card-text">
                                {{ $medicine->description ?? 'No description available.' }}
                            </p>


                            <div class="mt-auto">

                                {{-- Price --}}
                                <p class="mb-2">

                                    <strong>
                                        Price:
                                    </strong>

                                    Rs. {{ number_format(
                                        (float) $medicine->price,
                                        2
                                    ) }}

                                </p>


                                {{-- Stock --}}
                                <p class="mb-2">

                                    <strong>
                                        Available Stock:
                                    </strong>

                                    {{ $medicine->stock_quantity }}

                                </p>


                                {{-- Prescription Section --}}
                                @if ($medicine->requires_prescription)

                                    <span class="badge bg-warning text-dark mb-3">
                                        Prescription Required
                                    </span>


                                    {{-- No Prescription Uploaded --}}
                                    @if (!$latestPrescription)

                                        <form
                                            action="{{ route('prescriptions.store', $medicine) }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            class="mb-3"
                                        >

                                            @csrf

                                            <div class="mb-2">

                                                <label
                                                    for="prescription-{{ $medicine->id }}"
                                                    class="form-label"
                                                >
                                                    Upload Prescription
                                                </label>

                                                <input
                                                    type="file"
                                                    id="prescription-{{ $medicine->id }}"
                                                    name="prescription_file"
                                                    class="form-control"
                                                    accept=".jpg,.jpeg,.png,.pdf"
                                                    required
                                                >

                                                <div class="form-text">
                                                    Accepted: JPG, JPEG, PNG, PDF.
                                                    Maximum size: 5 MB.
                                                </div>

                                            </div>


                                            <button
                                                type="submit"
                                                class="btn btn-outline-primary w-100"
                                            >
                                                Upload Prescription
                                            </button>

                                        </form>


                                    {{-- Pending Prescription --}}
                                    @elseif ($latestPrescription->status->value === 'pending')

                                        <div class="alert alert-warning py-2 mb-3">

                                            <strong>
                                                Prescription Pending
                                            </strong>

                                            <div class="mt-1">
                                                Your prescription is waiting
                                                for admin review.
                                            </div>

                                        </div>


                                    {{-- Approved Prescription --}}
                                    @elseif ($latestPrescription->status->value === 'approved')

                                        <div class="alert alert-success py-2 mb-3">

                                            <strong>
                                                Prescription Approved
                                            </strong>

                                            <div class="mt-1">
                                                You can proceed with this medicine.
                                            </div>

                                        </div>


                                    {{-- Rejected Prescription --}}
                                    @elseif ($latestPrescription->status->value === 'rejected')

                                        <div class="alert alert-danger py-2 mb-3">

                                            <strong>
                                                Prescription Rejected
                                            </strong>

                                            @if ($latestPrescription->rejection_reason)

                                                <div class="mt-1">

                                                    <strong>
                                                        Reason:
                                                    </strong>

                                                    {{ $latestPrescription->rejection_reason }}

                                                </div>

                                            @endif

                                        </div>


                                        <form
                                            action="{{ route('prescriptions.store', $medicine) }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            class="mb-3"
                                        >

                                            @csrf

                                            <div class="mb-2">

                                                <label
                                                    for="prescription-{{ $medicine->id }}"
                                                    class="form-label"
                                                >
                                                    Upload New Prescription
                                                </label>

                                                <input
                                                    type="file"
                                                    id="prescription-{{ $medicine->id }}"
                                                    name="prescription_file"
                                                    class="form-control"
                                                    accept=".jpg,.jpeg,.png,.pdf"
                                                    required
                                                >

                                                <div class="form-text">
                                                    Accepted: JPG, JPEG, PNG, PDF.
                                                    Maximum size: 5 MB.
                                                </div>

                                            </div>


                                            <button
                                                type="submit"
                                                class="btn btn-outline-primary w-100"
                                            >
                                                Upload New Prescription
                                            </button>

                                        </form>

                                    @endif


                                @else

                                    <span class="badge bg-success mb-3">
                                        No Prescription Required
                                    </span>

                                @endif


                                {{-- Add to Cart --}}
                                <form
                                    method="POST"
                                    action="{{ route('cart.store', $medicine) }}"
                                >

                                    @csrf

                                    <div class="mb-2">

                                        <label
                                            for="quantity-{{ $medicine->id }}"
                                            class="form-label"
                                        >
                                            Quantity
                                        </label>

                                        <input
                                            type="number"
                                            id="quantity-{{ $medicine->id }}"
                                            name="quantity"
                                            value="1"
                                            min="1"
                                            max="{{ $medicine->stock_quantity }}"
                                            class="form-control"
                                            required
                                        >

                                    </div>


                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100"
                                    >
                                        Add to Cart
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- Pagination --}}
        <div class="mt-3">

            {{ $medicines->links() }}

        </div>

    @endif

</div>

@endsection
