@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')

<div class="container mt-5">

    <h2>Patient Dashboard</h2>

    <p class="text-muted">
        Welcome, {{ auth()->user()->name }}.
    </p>

    <div class="row mt-4">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>My Appointments</h5>
                    <p>View your upcoming appointments.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Book Appointment</h5>
                    <p>Request a new appointment.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>My Medical Records</h5>
                    <p>View your available medical information.</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
