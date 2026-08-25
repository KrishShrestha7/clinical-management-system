@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('content')

<div class="container mt-5">

    <h2>Receptionist Dashboard</h2>

    <p class="text-muted">
        Welcome, {{ auth()->user()->name }}.
    </p>

    <div class="row mt-4">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Patients</h5>
                    <p>Register and view patients.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Appointments</h5>
                    <p>Schedule and manage appointments.</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
