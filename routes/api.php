<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PatientProfileController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\PatientController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public api routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//protected api routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [PatientProfileController::class, 'show']);
    Route::post('/profile', [PatientProfileController::class, 'store']);
    Route::put('/profile', [PatientProfileController::class, 'update']);

    Route::get('/medicines', [MedicineController::class, 'index']);
    Route::get('/medicines/{medicine}', [MedicineController::class, 'show']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::post(
        '/cart/items/{medicine}',
        [CartController::class, 'store']
    );
    Route::delete(
        '/cart/items/{medicine}',
        [CartController::class, 'destroy']
    );

});

Route::apiResource('patients', PatientController::class);
