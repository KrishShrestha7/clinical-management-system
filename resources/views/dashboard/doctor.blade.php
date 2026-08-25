@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')

<div class="container mt-5">

    <h2>Doctor Dashboard</h2>

    <p class="text-muted">
        Welcome, Dr. {{ auth()->user()->name }}.
    </p>

    <div class="row mt-4">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Patients</h5>
                    <p>View and manage patient information.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Appointments</h5>
                    <p>View upcoming appointments.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Medical Records</h5>
                    <p>Access patient medical records.</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
