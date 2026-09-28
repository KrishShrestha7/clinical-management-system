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
| These routes are assigned the "api" middleware group.
|
*/


/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

Route::post(
    '/register',
    [AuthController::class, 'register']
);

Route::post(
    '/login',
    [AuthController::class, 'login']
);


/*
|--------------------------------------------------------------------------
| Protected API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/user',
        function (Request $request) {
            return $request->user();
        }
    );

    Route::get(
        '/me',
        [AuthController::class, 'me']
    );

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    );


    /*
    |--------------------------------------------------------------------------
    | Patient Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [PatientProfileController::class, 'show']
    );

    Route::post(
        '/profile',
        [PatientProfileController::class, 'store']
    );

    Route::put(
        '/profile',
        [PatientProfileController::class, 'update']
    );


    /*
    |--------------------------------------------------------------------------
    | Medicines
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/medicines',
        [MedicineController::class, 'index']
    );

    Route::get(
        '/medicines/{medicine}',
        [MedicineController::class, 'show']
    );


    /*
    |--------------------------------------------------------------------------
    | Cart
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/cart',
        [CartController::class, 'index']
    );

    Route::post(
        '/cart/items/{medicine}',
        [CartController::class, 'store']
    );

    Route::delete(
        '/cart/items/{medicine}',
        [CartController::class, 'destroy']
    );


    /*
    |--------------------------------------------------------------------------
    | Patients
    |--------------------------------------------------------------------------
    |
    | Explicit API route names prevent collisions with the web routes.
    |
    */

    Route::apiResource(
        'patients',
        PatientController::class
    )->names([
        'index' => 'api.patients.index',
        'store' => 'api.patients.store',
        'show' => 'api.patients.show',
        'update' => 'api.patients.update',
        'destroy' => 'api.patients.destroy',
    ]);

});
