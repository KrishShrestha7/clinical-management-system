@extends('layouts.app')

@section('title', 'Admin Order Details')

@section('content')

<div class="container mt-4">

    @php
        $latestPayment = $order->payments
            ->sortByDesc('id')
            ->first();
    @endphp


    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>Order Details</h2>

            <p class="text-muted mb-0">
                {{ $order->order_number }}
            </p>

        </div>

        <a
            href="{{ route('admin.orders.index') }}"
            class="btn btn-secondary"
        >
            Back to Orders
        </a>

    </div>


    {{-- Patient Information --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">Patient Information</h5>
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
            <h5 class="mb-0">Order Information</h5>
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

                <div class="col-md-4 mb-3">

                    <strong>Order Date</strong>

                    <p class="mb-0">
                        {{ $order->created_at->format('Y-m-d H:i') }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Medicines --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">Ordered Medicines</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>
                            <th>Medicine</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Prescription</th>
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

                                <td>

                                    @if ($item->medicine?->requires_prescription)

                                        <span class="badge bg-warning text-dark">
                                            Required
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            Not Required
                                        </span>

                                    @endif

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

        </div>

    </div>


    {{-- Billing --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">Billing Summary</h5>
        </div>

        <div class="card-body">

            @if ($order->subtotal_amount !== null)

                <div class="d-flex justify-content-between mb-2">

                    <span>Subtotal</span>

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

            @endif


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


    {{-- Payment --}}
    <div class="card shadow-sm mb-4">

        <div class="card-header">
            <h5 class="mb-0">Payment Information</h5>
        </div>

        <div class="card-body">

            @if ($latestPayment)

                <p class="mb-2">

                    <strong>Status:</strong>

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
                            {{ ucfirst($latestPayment->status->value) }}
                        </span>

                    @endif

                </p>


                <p class="mb-2">

                    <strong>
                        Payment Method:
                    </strong>

                    {{ ucfirst($latestPayment->payment_method) }}

                </p>


                <p class="mb-2">

                    <strong>
                        Amount:
                    </strong>

                    Rs. {{ number_format(
                        (float) $latestPayment->amount,
                        2
                    ) }}

                </p>


                <p class="mb-2">

                    <strong>
                        Transaction Reference:
                    </strong>

                    {{ $latestPayment->transaction_reference }}

                </p>


                @if ($latestPayment->paid_at)

                    <p class="mb-0">

                        <strong>
                            Paid At:
                        </strong>

                        {{ $latestPayment->paid_at->format('Y-m-d H:i') }}

                    </p>

                @endif

            @else

                <p class="text-muted mb-0">
                    No payment has been recorded for this order.
                </p>

            @endif

        </div>

    </div>

</div>

@endsection
