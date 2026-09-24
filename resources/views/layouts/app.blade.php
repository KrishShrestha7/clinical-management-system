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

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        {{-- Dashboard / Home --}}
        <a
            href="{{
                auth()->user()->isAdmin()
                    ? route('admin.dashboard')
                    : (
                        auth()->user()->isReceptionist()
                            ? route('receptionist.dashboard')
                            : (
                                auth()->user()->isDoctor()
                                    ? route('doctor.dashboard')
                                    : route('dashboard')
                            )
                    )
            }}"
            class="navbar-brand"
        >
            Clinical Management System
        </a>


        @auth

            <div class="d-flex align-items-center gap-3">


                {{-- Patient Navigation --}}
                @if (auth()->user()->isPatient())

                    <a
                        href="{{ route('appointments.index') }}"
                        class="text-white text-decoration-none"
                    >
                        My Appointments
                    </a>

                    <a
                        href="{{ route('medicines.catalog') }}"
                        class="text-white text-decoration-none"
                    >
                        Medicines
                    </a>

                    <a
                        href="{{ route('orders.index') }}"
                        class="text-white text-decoration-none"
                    >
                        My Orders
                    </a>

                    <a
                        href="{{ route('patient-profile.show') }}"
                        class="text-white text-decoration-none"
                    >
                        My Profile
                    </a>

                @endif


                {{-- Admin Navigation --}}
                @if (auth()->user()->isAdmin())

                    <a
                        href="{{ route('admin.patients.index') }}"
                        class="text-white text-decoration-none"
                    >
                        Patients
                    </a>

                    <a
                        href="{{ route('admin.staff.index') }}"
                        class="text-white text-decoration-none"
                    >
                        Staff
                    </a>

                @endif


                {{-- Receptionist Navigation --}}
                @if (auth()->user()->isReceptionist())

                    <a
                        href="{{ route('receptionist.dashboard') }}"
                        class="text-white text-decoration-none"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('patients.index') }}"
                        class="text-white text-decoration-none"
                    >
                        Patients
                    </a>

                    <a
                        href="{{ route('receptionist.appointments.index') }}"
                        class="text-white text-decoration-none"
                    >
                        Appointments
                    </a>

                    <a
                        href="{{ route('receptionist.orders.index') }}"
                        class="text-white text-decoration-none"
                    >
                        Orders
                    </a>

                @endif


                {{-- Doctor Navigation --}}
                @if (auth()->user()->isDoctor())

                    <a
                        href="{{ route('doctor.dashboard') }}"
                        class="text-white text-decoration-none"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('doctor.appointments.index') }}"
                        class="text-white text-decoration-none"
                    >
                        My Appointments
                    </a>

                @endif


                {{-- Logged-in User Name --}}
                <span class="text-white">
                    {{ auth()->user()->name }}
                </span>


                {{-- Logout --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="mb-0"
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


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>
