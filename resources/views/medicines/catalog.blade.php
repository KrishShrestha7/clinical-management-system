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

    @if ($medicines->isEmpty())

        <div class="alert alert-info">
            No medicines are currently available.
        </div>

    @else

        <div class="row">

            @foreach ($medicines as $medicine)

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

                                <p class="mb-2">

                                    <strong>Price:</strong>

                                    Rs. {{ number_format((float) $medicine->price, 2) }}

                                </p>

                                <p class="mb-2">

                                    <strong>Available Stock:</strong>

                                    {{ $medicine->stock_quantity }}

                                </p>

                                @if ($medicine->requires_prescription)

                                    <span class="badge bg-warning text-dark mb-3">
                                        Prescription Required
                                    </span>

                                @else

                                    <span class="badge bg-success mb-3">
                                        No Prescription Required
                                    </span>

                                @endif

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

                </div>

            @endforeach

        </div>

        <div class="mt-3">

            {{ $medicines->links() }}

        </div>

    @endif

</div>

@endsection
