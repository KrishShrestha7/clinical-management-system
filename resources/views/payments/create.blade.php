@extends('layouts.app')

@section('title', 'Pay for Order')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Payment</h2>

            <p class="text-muted mb-0">
                {{ $order->order_number }}
            </p>
        </div>

        <a
            href="{{ route('orders.show', $order) }}"
            class="btn btn-secondary"
        >
            Back to Order
        </a>

    </div>

    @if (session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="mb-3">
                Payment Summary
            </h5>

            <div class="mb-3">
                <strong>Order Number:</strong>
                {{ $order->order_number }}
            </div>

            <div class="mb-3">
                <strong>Order Status:</strong>
                {{ ucfirst($order->status) }}
            </div>

            <div class="mb-4">
                <strong>Amount to Pay:</strong>

                <span class="fs-5">
                    Rs. {{ number_format(
                        (float) $order->total_amount,
                        2
                    ) }}
                </span>
            </div>

            <hr>

            <form
                method="POST"
                action="{{ route('payments.store', $order) }}"
            >

                @csrf
                <div class="alert alert-info">
                    This project currently uses a demo payment method
                    for testing the payment workflow.
                </div>

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    Pay Rs. {{ number_format(
                        (float) $order->total_amount,
                        2
                    ) }}
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
