<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Clinical Management System')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>
<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a
            href="{{ route('dashboard') }}"
            class="navbar-brand"
        >
            Clinical Management System
        </a>

        @auth

            <div class="d-flex align-items-center gap-3">

                @if (
                    auth()->user()->isAdmin()
                    || auth()->user()->isDoctor()
                    || auth()->user()->isReceptionist()
                )

                    <a
                        href="{{ route('patients.index') }}"
                        class="text-white text-decoration-none"
                    >
                        Patients
                    </a>

                @endif

                <span class="text-white">
                    {{ auth()->user()->name }}
                </span>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-light btn-sm"
                    >
                        Logout
                    </button>

                </form>

            </div>

        @endauth

    </div>

</nav>

<main>

    @yield('content')

</main>

</body>

</html>

