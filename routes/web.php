<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\MedicineCatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\Admin\PrescriptionController as AdminPrescriptionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get(
        '/reset-password/{token}',
        [ResetPasswordController::class, 'showResetForm']
    )->name('password.reset');

    Route::post(
        '/reset-password',
        [ResetPasswordController::class, 'reset']
    )->name('password.update');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/my-profile', [PatientProfileController::class, 'show'])
        ->name('patient-profile.show');

    Route::get('/my-profile/complete', [PatientProfileController::class, 'create'])
        ->name('patient-profile.create');

    Route::post('/my-profile/complete', [PatientProfileController::class, 'store'])
        ->name('patient-profile.store');

    Route::get('/my-profile/edit', [PatientProfileController::class, 'edit'])
        ->name('patient-profile.edit');

    Route::put('/my-profile', [PatientProfileController::class, 'update'])
        ->name('patient-profile.update');

    Route::get('/medicines', [MedicineCatalogController::class, 'index'])
        ->name('medicines.catalog');

    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/medicines/{medicine}/cart', [CartController::class, 'store'])
        ->name('cart.store');

    Route::delete('/cart/{medicine}', [CartController::class, 'remove'])
        ->name('cart.remove');

    Route::post('/checkout', [CartController::class, 'checkout'])
        ->name('cart.checkout');

    Route::get('/my-orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/my-orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::get(
        '/my-orders/{order}/payment',
        [PaymentController::class, 'create']
    )->name('payments.create');

    Route::post(
        '/my-orders/{order}/payment',
        [PaymentController::class, 'store']
    )->name('payments.store');

    Route::get(
        '/my-orders/{order}/receipt',
        [OrderController::class, 'receipt']
    )->name('orders.receipt');

    Route::post(
        '/medicines/{medicine}/prescription',
        [PrescriptionController::class, 'store']
    )->name('prescriptions.store');

    Route::resource('patients', PatientController::class);

    Route::get(
        '/appointments',
        [AppointmentController::class, 'index']
    )->name('appointments.index');

    Route::get(
        '/appointments/create',
        [AppointmentController::class, 'create']
    )->name('appointments.create');

    Route::post(
        '/appointments',
        [AppointmentController::class, 'store']
    )->name('appointments.store');

    Route::get(
        '/appointments/{appointment}',
        [AppointmentController::class, 'show']
    )->name('appointments.show');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('dashboard');

        Route::resource('medicines', MedicineController::class)
        ->except(['show']);

        Route::get(
            '/prescriptions',
            [AdminPrescriptionController::class, 'index']
        )->name('prescriptions.index');

        Route::patch(
            '/prescriptions/{prescription}/approve',
            [AdminPrescriptionController::class, 'approve']
        )->name('prescriptions.approve');

        Route::patch(
            '/prescriptions/{prescription}/reject',
            [AdminPrescriptionController::class, 'reject']
        )->name('prescriptions.reject');

        Route::get(
            '/orders',
            [AdminOrderController::class, 'index']
        )->name('orders.index');

        Route::get(
            '/orders/{order}',
            [AdminOrderController::class, 'show']
        )->name('orders.show');

        Route::get(
            '/payments',
            [AdminPaymentController::class, 'index']
        )->name('payments.index');

        Route::get(
            '/patients',
            [AdminPatientController::class, 'index']
        )->name('patients.index');

        Route::get(
            '/patients/{patient}',
            [AdminPatientController::class, 'show']
        )->name('patients.show');

        Route::get(
            '/staff',
            [AdminStaffController::class, 'index']
        )->name('staff.index');

        Route::get(
            '/staff/create',
            [AdminStaffController::class, 'create']
        )->name('staff.create');

        Route::post(
            '/staff',
            [AdminStaffController::class, 'store']
        )->name('staff.store');

        Route::get(
            '/staff/{staff}',
            [AdminStaffController::class, 'show']
        )->name('staff.show');

        Route::get(
            '/staff/{staff}/edit',
            [AdminStaffController::class, 'edit']
        )->name('staff.edit');

        Route::put(
            '/staff/{staff}',
            [AdminStaffController::class, 'update']
        )->name('staff.update');

        Route::post(
            '/staff/{staff}/password-reset',
            [AdminStaffController::class, 'sendPasswordReset']
        )->name('staff.password-reset');

    });


