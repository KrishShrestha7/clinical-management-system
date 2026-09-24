@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')

<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Manage Orders</h2>

            <p class="text-muted mb-0">
                View patient orders and payment information.
            </p>
        </div>

        <a
            href="{{ route('receptionist.dashboard') }}"
            class="btn btn-secondary"
        >
            Back to Dashboard
        </a>

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


    @if ($orders->isEmpty())

        <div class="alert alert-info">
            No patient orders are available.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Order Number</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Medicines</th>
                                <th>Total</th>
                                <th>Order Status</th>
                                <th>Payment</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($orders as $order)

                                @php
                                    $latestPayment = $order->payments
                                        ->sortByDesc('id')
                                        ->first();
                                @endphp

                                <tr>

                                    {{-- Order Number --}}
                                    <td>
                                        <strong>
                                            {{ $order->order_number }}
                                        </strong>
                                    </td>


                                    {{-- Patient --}}
                                    <td>
                                        {{ $order->patient->name }}
                                    </td>


                                    {{-- Date --}}
                                    <td>
                                        {{ $order->created_at->format(
                                            'Y-m-d H:i'
                                        ) }}
                                    </td>


                                    {{-- Medicine Count --}}
                                    <td>

                                        {{ $order->items_count }}

                                        {{ $order->items_count === 1
                                            ? 'Medicine'
                                            : 'Medicines' }}

                                    </td>


                                    {{-- Total --}}
                                    <td>
                                        Rs. {{ number_format(
                                            (float) $order->total_amount,
                                            2
                                        ) }}
                                    </td>


                                    {{-- Order Status --}}
                                    <td>

                                        @if ($order->status === 'paid')

                                            <span class="badge bg-success">
                                                Paid
                                            </span>

                                        @elseif ($order->status === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst($order->status) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Payment Status --}}
                                    <td>

                                        @if (!$latestPayment)

                                            <span class="badge bg-secondary">
                                                No Payment
                                            </span>

                                        @elseif (
                                            $latestPayment->status->value === 'successful'
                                        )

                                            <span class="badge bg-success">
                                                Successful
                                            </span>

                                        @elseif (
                                            $latestPayment->status->value === 'pending'
                                        )

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif (
                                            $latestPayment->status->value === 'failed'
                                        )

                                            <span class="badge bg-danger">
                                                Failed
                                            </span>

                                        @elseif (
                                            $latestPayment->status->value === 'cancelled'
                                        )

                                            <span class="badge bg-secondary">
                                                Cancelled
                                            </span>

                                        @elseif (
                                            $latestPayment->status->value === 'refunded'
                                        )

                                            <span class="badge bg-info text-dark">
                                                Refunded
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst(
                                                    $latestPayment->status->value
                                                ) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Action --}}
                                    <td>

                                        <a
                                            href="{{ route(
                                                'receptionist.orders.show',
                                                $order
                                            ) }}"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            View
                                        </a>

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

            {{ $orders->links() }}

        </div>

    @endif

</div>

@endsection
