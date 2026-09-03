@extends('layouts.app')

@section('title', 'Payment Receipt')

@section('content')

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-md-9">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2>
                        Payment Receipt
                    </h2>

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


            <div class="card shadow-sm">

                <div class="card-body p-4">

                    {{-- Receipt Heading --}}
                    <div class="text-center mb-4">

                        <h3>
                            Clinical Management System
                        </h3>

                        <p class="text-muted mb-0">
                            Medicine Payment Receipt
                        </p>

                    </div>

                    <hr>


                    {{-- Order / Patient Information --}}
                    <div class="row mb-4">

                        <div class="col-md-6">

                            <p class="mb-1">

                                <strong>
                                    Order Number:
                                </strong>

                                {{ $order->order_number }}

                            </p>

                            <p class="mb-1">

                                <strong>
                                    Patient:
                                </strong>

                                {{ $order->patient->name }}

                            </p>

                            <p class="mb-0">

                                <strong>
                                    Order Date:
                                </strong>

                                {{ $order->created_at->format('Y-m-d H:i') }}

                            </p>

                        </div>


                        <div class="col-md-6">

                            <p class="mb-1">

                                <strong>
                                    Payment Reference:
                                </strong>

                                {{ $successfulPayment->transaction_reference }}

                            </p>

                            <p class="mb-1">

                                <strong>
                                    Payment Status:
                                </strong>

                                <span class="badge bg-success">
                                    Successful
                                </span>

                            </p>

                            <p class="mb-0">

                                <strong>
                                    Paid At:
                                </strong>

                                {{ $successfulPayment->paid_at?->format('Y-m-d H:i') }}

                            </p>

                        </div>

                    </div>


                    {{-- Medicines --}}
                    <div class="table-responsive mb-4">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>
                                        Medicine
                                    </th>

                                    <th class="text-end">
                                        Unit Price
                                    </th>

                                    <th class="text-center">
                                        Qty
                                    </th>

                                    <th class="text-end">
                                        Amount
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($order->items as $item)

                                    <tr>

                                        <td>
                                            {{ $item->medicine_name }}
                                        </td>

                                        <td class="text-end">
                                            Rs. {{ number_format(
                                                (float) $item->unit_price,
                                                2
                                            ) }}
                                        </td>

                                        <td class="text-center">
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


                    {{-- Billing --}}
                    <div class="row justify-content-end">

                        <div class="col-md-5">

                            @if ($order->subtotal_amount !== null)

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

                            @endif


                            <div class="d-flex justify-content-between">

                                <h5>
                                    Total Paid
                                </h5>

                                <h5>
                                    Rs. {{ number_format(
                                        (float) $successfulPayment->amount,
                                        2
                                    ) }}
                                </h5>

                            </div>

                        </div>

                    </div>


                    <hr class="mt-4">


                    <div class="text-center">

                        <p class="text-muted mb-0">
                            Thank you for your payment.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
