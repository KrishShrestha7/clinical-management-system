@extends('layouts.app')

@section('title', 'Patients')

@section('content')
    <h1>Patients</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->date_of_birth }}</td>
                    <td>{{ $patient->gender }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $patients->links() }}
@endsection
