@extends('layouts.app')

@section('title', 'Order Details')

@section('content')

<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Order Details</h2>

            <p class="text-muted mb-0">
                {{ $order->order_number }}
            </p>
        </div>

        <a
            href="{{ route('receptionist.orders.index') }}"
            class="btn btn-secondary"
        >
            Back to Orders
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


    {{-- Patient Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Patient Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Name</strong>

                    <p class="mb-0">
                        {{ $order->patient->name }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Email</strong>

                    <p class="mb-0">
                        {{ $order->patient->email ?? 'Not provided' }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Phone</strong>

                    <p class="mb-0">
                        {{ $order->patient->phone ?? 'Not provided' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Order Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Order Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <strong>Order Number</strong>

                    <p class="mb-0">
                        {{ $order->order_number }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Order Date</strong>

                    <p class="mb-0">
                        {{ $order->created_at->format('F d, Y h:i A') }}
                    </p>

                </div>


                <div class="col-md-4 mb-3">

                    <strong>Status</strong>

                    <p class="mb-0">

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

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Ordered Medicines --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Ordered Medicines
            </h5>
        </div>

        <div class="card-body">

            @if ($order->items->isEmpty())

                <p class="text-muted mb-0">
                    No medicines were found for this order.
                </p>

            @else

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Medicine</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Line Total</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($order->items as $item)

                                <tr>

                                    <td>
                                        {{ $item->medicine_name }}
                                    </td>

                                    <td>
                                        Rs. {{ number_format(
                                            (float) $item->unit_price,
                                            2
                                        ) }}
                                    </td>

                                    <td>
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="text-end">
                                        Rs. {{ number_format(
                                            (float) $item->line_total,
                                            2
                                        ) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>


    {{-- Billing Summary --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Billing Summary
            </h5>
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">

                <span>
                    Subtotal
                </span>

                <strong>
                    Rs. {{ number_format(
                        (float) $order->subtotal_amount,
                        2
                    ) }}
                </strong>

            </div>


            <div class="d-flex justify-content-between mb-2">

                <span>
                    VAT
                    ({{ number_format(
                        (float) $order->vat_rate,
                        2
                    ) }}%)
                </span>

                <strong>
                    Rs. {{ number_format(
                        (float) $order->vat_amount,
                        2
                    ) }}
                </strong>

            </div>


            <hr>


            <div class="d-flex justify-content-between">

                <h5 class="mb-0">
                    Grand Total
                </h5>

                <h5 class="mb-0">
                    Rs. {{ number_format(
                        (float) $order->total_amount,
                        2
                    ) }}
                </h5>

            </div>

        </div>

    </div>


    {{-- Payment Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                Payment Information
            </h5>
        </div>

        <div class="card-body">

            @php
                $latestPayment = $order->payments
                    ->sortByDesc('id')
                    ->first();
            @endphp


            @if ($latestPayment)

                <div class="row">

                    {{-- Payment Status --}}
                    <div class="col-md-4 mb-3">

                        <strong>
                            Payment Status
                        </strong>

                        <p class="mb-0">

                            @if ($latestPayment->status->value === 'successful')

                                <span class="badge bg-success">
                                    Successful
                                </span>

                            @elseif ($latestPayment->status->value === 'pending')

                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @elseif ($latestPayment->status->value === 'failed')

                                <span class="badge bg-danger">
                                    Failed
                                </span>

                            @elseif ($latestPayment->status->value === 'cancelled')

                                <span class="badge bg-secondary">
                                    Cancelled
                                </span>

                            @elseif ($latestPayment->status->value === 'refunded')

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

                        </p>

                    </div>


                    {{-- Payment Method --}}
                    <div class="col-md-4 mb-3">

                        <strong>
                            Payment Method
                        </strong>

                        <p class="mb-0">
                            {{ ucfirst(
                                $latestPayment->payment_method
                            ) }}
                        </p>

                    </div>


                    {{-- Amount --}}
                    <div class="col-md-4 mb-3">

                        <strong>
                            Amount
                        </strong>

                        <p class="mb-0">
                            Rs. {{ number_format(
                                (float) $latestPayment->amount,
                                2
                            ) }}
                        </p>

                    </div>


                    {{-- Transaction Reference --}}
                    <div class="col-md-6 mb-3">

                        <strong>
                            Transaction Reference
                        </strong>

                        <p class="mb-0">
                            {{ $latestPayment->transaction_reference ?? 'Not available' }}
                        </p>

                    </div>


                    {{-- Paid At --}}
                    <div class="col-md-6 mb-3">

                        <strong>
                            Paid At
                        </strong>

                        <p class="mb-0">

                            @if ($latestPayment->paid_at)

                                {{ $latestPayment->paid_at->format(
                                    'F d, Y h:i A'
                                ) }}

                            @else

                                Not paid

                            @endif

                        </p>

                    </div>

                </div>

            @else

                <p class="text-muted mb-0">
                    No payment has been recorded for this order.
                </p>

            @endif

        </div>

    </div>


    {{-- Receipt --}}
    @if (
        $order->status === 'paid'
        && isset($latestPayment)
        && $latestPayment
        && $latestPayment->status->value === 'successful'
    )

        <div class="card shadow-sm">

            <div class="card-header">
                <h5 class="mb-0">
                    Billing Actions
                </h5>
            </div>

            <div class="card-body">

                <a
                    href="{{ route(
                        'receptionist.orders.receipt',
                        $order
                    ) }}"
                    class="btn btn-primary"
                >
                    View Receipt
                </a>

            </div>

        </div>

    @endif

</div>

@endsection
