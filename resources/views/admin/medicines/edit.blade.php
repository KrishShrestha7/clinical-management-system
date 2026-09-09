@extends('layouts.app')

@section('title', 'Edit Medicine')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Edit Medicine</h2>

            <p class="text-muted mb-0">
                Update medicine information.
            </p>
        </div>

        <a
            href="{{ route('admin.medicines.index') }}"
            class="btn btn-secondary"
        >
            Back to Medicines
        </a>

    </div>


    @if (session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card shadow-sm">

        <div class="card-body">

            <form
                method="POST"
                action="{{ route('admin.medicines.update', $medicine) }}"
            >

                @csrf
                @method('PUT')


                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Medicine Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $medicine->name) }}"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label
                        for="generic_name"
                        class="form-label"
                    >
                        Generic Name
                    </label>

                    <input
                        type="text"
                        id="generic_name"
                        name="generic_name"
                        class="form-control @error('generic_name') is-invalid @enderror"
                        value="{{ old('generic_name', $medicine->generic_name) }}"
                    >

                    @error('generic_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">

                    <label
                        for="description"
                        class="form-label"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                    >{{ old('description', $medicine->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label
                            for="price"
                            class="form-label"
                        >
                            Price
                        </label>

                        <input
                            type="number"
                            id="price"
                            name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $medicine->price) }}"
                            min="0"
                            step="0.01"
                            required
                        >

                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="col-md-6 mb-3">

                        <label
                            for="stock_quantity"
                            class="form-label"
                        >
                            Stock Quantity
                        </label>

                        <input
                            type="number"
                            id="stock_quantity"
                            name="stock_quantity"
                            class="form-control @error('stock_quantity') is-invalid @enderror"
                            value="{{ old('stock_quantity', $medicine->stock_quantity) }}"
                            min="0"
                            required
                        >

                        @error('stock_quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>


                <div class="mb-3">

                    <label
                        for="requires_prescription"
                        class="form-label"
                    >
                        Prescription Required
                    </label>

                    <select
                        id="requires_prescription"
                        name="requires_prescription"
                        class="form-select @error('requires_prescription') is-invalid @enderror"
                        required
                    >

                        <option
                            value="0"
                            @selected(
                                old(
                                    'requires_prescription',
                                    $medicine->requires_prescription ? '1' : '0'
                                ) === '0'
                            )
                        >
                            No
                        </option>

                        <option
                            value="1"
                            @selected(
                                old(
                                    'requires_prescription',
                                    $medicine->requires_prescription ? '1' : '0'
                                ) === '1'
                            )
                        >
                            Yes
                        </option>

                    </select>

                    @error('requires_prescription')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-4">

                    <label
                        for="is_active"
                        class="form-label"
                    >
                        Status
                    </label>

                    <select
                        id="is_active"
                        name="is_active"
                        class="form-select @error('is_active') is-invalid @enderror"
                        required
                    >

                        <option
                            value="1"
                            @selected(
                                old(
                                    'is_active',
                                    $medicine->is_active ? '1' : '0'
                                ) === '1'
                            )
                        >
                            Active
                        </option>

                        <option
                            value="0"
                            @selected(
                                old(
                                    'is_active',
                                    $medicine->is_active ? '1' : '0'
                                ) === '0'
                            )
                        >
                            Inactive
                        </option>

                    </select>

                    @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Medicine
                    </button>

                    <a
                        href="{{ route('admin.medicines.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
