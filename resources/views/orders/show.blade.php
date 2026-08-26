@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Order Details</h2>

            <p class="text-muted mb-0">
                {{ $order->order_number }}
            </p>
        </div>

        <a
            href="{{ route('orders.index') }}"
            class="btn btn-secondary"
        >
            Back to My Orders
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

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <strong>Order Number</strong>
                    <p>{{ $order->order_number }}</p>
                </div>

                <div class="col-md-4">
                    <strong>Status</strong>
                    <p>
                        <span class="badge bg-warning text-dark">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-4">
                    <strong>Order Date</strong>
                    <p>
                        {{ $order->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="mb-3">
                Medicines
            </h5>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Medicine</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Line Total</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($order->items as $item)

                            <tr>

                                <td>
                                    {{ $item->medicine_name }}
                                </td>

                                <td>
                                    Rs. {{ number_format((float) $item->unit_price, 2) }}
                                </td>

                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <td>
                                    Rs. {{ number_format((float) $item->line_total, 2) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <hr>

            <div class="d-flex justify-content-end">

                <h4>
                    Total:
                    Rs. {{ number_format((float) $order->total_amount, 2) }}
                </h4>

            </div>

        </div>

    </div>

</div>

@endsection
