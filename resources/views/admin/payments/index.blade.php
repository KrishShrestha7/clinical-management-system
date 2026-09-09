@extends('layouts.app')

@section('title', 'Payment Records')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Payment Records</h2>

            <p class="text-muted mb-0">
                View all payment activity in the system.
            </p>
        </div>

        <a
            href="{{ route('admin.dashboard') }}"
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


    @if (session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    @if ($payments->isEmpty())

        <div class="alert alert-info">
            No payment records are available.
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
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Reference</th>
                                <th>Paid At</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($payments as $payment)

                                <tr>

                                    {{-- Order --}}
                                    <td>
                                        <strong>
                                            {{ $payment->order->order_number }}
                                        </strong>
                                    </td>


                                    {{-- Patient --}}
                                    <td>
                                        {{ $payment->order->patient->name }}
                                    </td>


                                    {{-- Amount --}}
                                    <td>
                                        Rs. {{ number_format(
                                            (float) $payment->amount,
                                            2
                                        ) }}
                                    </td>


                                    {{-- Payment Method --}}
                                    <td>
                                        {{ ucfirst($payment->payment_method) }}
                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if ($payment->status->value === 'successful')

                                            <span class="badge bg-success">
                                                Successful
                                            </span>

                                        @elseif ($payment->status->value === 'pending')

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        @elseif ($payment->status->value === 'failed')

                                            <span class="badge bg-danger">
                                                Failed
                                            </span>

                                        @elseif ($payment->status->value === 'cancelled')

                                            <span class="badge bg-secondary">
                                                Cancelled
                                            </span>

                                        @elseif ($payment->status->value === 'refunded')

                                            <span class="badge bg-info text-dark">
                                                Refunded
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ ucfirst($payment->status->value) }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Transaction Reference --}}
                                    <td>
                                        {{ $payment->transaction_reference ?? '—' }}
                                    </td>


                                    {{-- Paid At --}}
                                    <td>

                                        @if ($payment->paid_at)

                                            {{ $payment->paid_at->format('Y-m-d H:i') }}

                                        @else

                                            <span class="text-muted">
                                                Not paid
                                            </span>

                                        @endif

                                    </td>


                                    {{-- View Related Order --}}
                                    <td>

                                        <a
                                            href="{{ route(
                                                'admin.orders.show',
                                                $payment->order
                                            ) }}"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            View Order
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
            {{ $payments->links() }}
        </div>

    @endif

</div>

@endsection
