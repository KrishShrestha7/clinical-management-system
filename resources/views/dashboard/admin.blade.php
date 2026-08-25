@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container mt-5">

    <h2>Admin Dashboard</h2>

    <p class="text-muted">
        Welcome, {{ auth()->user()->name }}.
    </p>

    <div class="row mt-4">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>User Management</h5>
                    <p>Manage system users and their roles.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Patients</h5>
                    <p>View and manage patient records.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>System Overview</h5>
                    <p>View clinical system information.</p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
