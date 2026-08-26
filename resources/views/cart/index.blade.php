@extends('layouts.app')

@section('title', 'Medicine Cart')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Medicine Cart</h2>

            <p class="text-muted mb-0">
                Review medicines before placing your order.
            </p>
        </div>

        <a
            href="{{ route('medicines.catalog') }}"
            class="btn btn-secondary"
        >
            Continue Shopping
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

    @if (empty($items))

        <div class="alert alert-info">
            Your medicine cart is empty.
        </div>

    @else

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>
                                <th>Medicine</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($items as $item)

                                <tr>

                                    <td>
                                        {{ $item['name'] }}
                                    </td>

                                    <td>
                                        Rs. {{ number_format((float) $item['price'], 2) }}
                                    </td>

                                    <td>
                                        {{ $item['quantity'] }}
                                    </td>

                                    <td>
                                        Rs.
                                        {{ number_format(
                                            (float) $item['price'] * $item['quantity'],
                                            2
                                        ) }}
                                    </td>

                                    <td>

                                        <form
                                            method="POST"
                                            action="{{ route('cart.remove', $item['medicine_id']) }}"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                            >
                                                Remove
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        Total:
                        Rs. {{ number_format((float) $total, 2) }}
                    </h4>

                    <form
                        method="POST"
                        action="{{ route('cart.checkout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            Place Order
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection
