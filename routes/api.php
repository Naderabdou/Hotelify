<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BookingController;



Route::middleware('localization')->namespace('API')->group(function () {

    // ===========================Auth routes=========================== //
    Route::post('login', [UserController::class, 'login'])->middleware('login.throttle');
    Route::post('register', [UserController::class , 'register']);
    // ===========================End Auth routes=========================== //




    Route::middleware('auth:sanctum')->group(function () {

        // ===========================Available Rooms routes=========================== //
        Route::get('available-rooms', [RoomController::class, 'index']);
        // ===========================End Available Rooms routes======================= //

        // ============================ Booking routes =========================== //
        Route::post('booking', [BookingController::class, 'store']);
        // ===========================End Booking routes=========================== //

        // =========================== Logout routes =========================== //
        Route::post('logout', [UserController::class, 'logout']);

        // =========================== End Logout routes =========================== //

    });
});
