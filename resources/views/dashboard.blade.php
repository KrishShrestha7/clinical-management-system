<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard - Clinical Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <span class="navbar-brand">
            Clinical Management System
        </span>

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="btn btn-outline-light"
            >
                Logout
            </button>

        </form>

    </div>

</nav>

<div class="container mt-5">

    <h2>Dashboard</h2>

    <p>
        Welcome, {{ auth()->user()->name }}.
    </p>

</div>

</body>
</html>
