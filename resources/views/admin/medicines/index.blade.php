@extends('layouts.app')

@section('title', 'Manage Medicines')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Manage Medicines</h2>

            <p class="text-muted mb-0">
                Add, update, and manage medicines available in the system.
            </p>
        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.medicines.create') }}"
                class="btn btn-primary"
            >
                Add Medicine
            </a>

            <a
                href="{{ route('admin.dashboard') }}"
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


    @if ($medicines->isEmpty())

        <div class="alert alert-info">
            No medicines have been added yet.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Name</th>
                                <th>Generic Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Prescription</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($medicines as $medicine)

                                <tr>

                                    {{-- Name --}}
                                    <td>
                                        <strong>
                                            {{ $medicine->name }}
                                        </strong>
                                    </td>


                                    {{-- Generic Name --}}
                                    <td>
                                        {{ $medicine->generic_name ?? '—' }}
                                    </td>


                                    {{-- Price --}}
                                    <td>
                                        Rs. {{ number_format(
                                            (float) $medicine->price,
                                            2
                                        ) }}
                                    </td>


                                    {{-- Stock --}}
                                    <td>

                                        @if ($medicine->stock_quantity > 10)

                                            <span class="badge bg-success">
                                                {{ $medicine->stock_quantity }}
                                            </span>

                                        @elseif ($medicine->stock_quantity > 0)

                                            <span class="badge bg-warning text-dark">
                                                {{ $medicine->stock_quantity }}
                                            </span>

                                        @else

                                            <span class="badge bg-danger">
                                                Out of Stock
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Prescription Required --}}
                                    <td>

                                        @if ($medicine->requires_prescription)

                                            <span class="badge bg-warning text-dark">
                                                Required
                                            </span>

                                        @else

                                            <span class="badge bg-success">
                                                Not Required
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Active Status --}}
                                    <td>

                                        @if ($medicine->is_active)

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Inactive
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td>

                                        <div class="d-flex gap-2">

                                            <a
                                                href="{{ route(
                                                    'admin.medicines.edit',
                                                    $medicine
                                                ) }}"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="{{ route(
                                                    'admin.medicines.destroy',
                                                    $medicine
                                                ) }}"
                                                onsubmit="return confirm(
                                                    'Are you sure you want to delete this medicine?'
                                                );"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Pagination --}}
        <div class="mt-3">

            {{ $medicines->links() }}

        </div>

    @endif

</div>

@endsection
