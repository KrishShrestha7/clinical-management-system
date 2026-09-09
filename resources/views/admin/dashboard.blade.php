@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container mt-4">

    {{-- Header --}}
    <div class="mb-4">

        <h2>Admin Dashboard</h2>

        <p class="text-muted mb-0">
            Welcome, {{ auth()->user()->name }}.
        </p>

    </div>


    {{-- Statistics --}}
    <div class="row">

        {{-- Patients --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Patients
                    </h6>

                    <h3>
                        {{ $totalPatients }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Medicines --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Medicines
                    </h6>

                    <h3>
                        {{ $totalMedicines }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Orders --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Orders
                    </h6>

                    <h3>
                        {{ $totalOrders }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Revenue --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Revenue
                    </h6>

                    <h3>
                        Rs. {{ number_format(
                            (float) $totalRevenue,
                            2
                        ) }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    <div class="row">

        {{-- Pending Orders --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Orders
                    </h6>

                    <h3>
                        {{ $pendingOrders }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Paid Orders --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Paid Orders
                    </h6>

                    <h3>
                        {{ $paidOrders }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Low Stock --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Low Stock Medicines
                    </h6>

                    <h3>
                        {{ $lowStockMedicines }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Out of Stock --}}
        <div class="col-md-3 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Out of Stock
                    </h6>

                    <h3>
                        {{ $outOfStockMedicines }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    <div class="row">

        {{-- Successful Payments --}}
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Successful Payments
                    </h6>

                    <h3>
                        {{ $successfulPayments }}
                    </h3>

                </div>

            </div>

        </div>


        {{-- Pending Prescriptions --}}
        <div class="col-md-6 mb-4">

            <div class="card shadow-sm h-100">

                <div class="card-body">

                    <h6 class="text-muted">
                        Pending Prescriptions
                    </h6>

                    <h3>
                        {{ $pendingPrescriptions }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Quick Actions --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                Quick Actions
            </h5>

        </div>

        <div class="card-body">

            <div class="d-flex flex-wrap gap-2">

                <a
                    href="{{ route('admin.medicines.index') }}"
                    class="btn btn-primary"
                >
                    Manage Medicines
                </a>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="btn btn-outline-primary"
                >
                    Manage Orders
                </a>

                <a
                    href="{{ route('admin.payments.index') }}"
                    class="btn btn-outline-primary"
                >
                    Payment Records
                </a>

                <a
                    href="{{ route('admin.prescriptions.index') }}"
                    class="btn btn-outline-primary"
                >
                    Review Prescriptions
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
