@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>My Orders</h2>

            <p class="text-muted mb-0">
                View your medicine order history.
            </p>
        </div>

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-secondary"
        >
            Back to Dashboard
        </a>

    </div>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if ($orders->isEmpty())

        <div class="alert alert-info">
            You have not placed any medicine orders yet.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($orders as $order)

                                <tr>

                                    <td>
                                        {{ $order->order_number }}
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('Y-m-d H:i') }}
                                    </td>

                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        Rs. {{ number_format((float) $order->total_amount, 2) }}
                                    </td>

                                    <td>

                                        <a
                                            href="{{ route('orders.show', $order) }}"
                                            class="btn btn-primary btn-sm"
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

        <div class="mt-3">

            {{ $orders->links() }}

        </div>

    @endif

</div>

@endsection
