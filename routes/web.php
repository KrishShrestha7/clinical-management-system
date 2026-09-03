<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\MedicineCatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
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

    Route::resource('patients', PatientController::class);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
