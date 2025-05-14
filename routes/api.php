<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\BookingController;



Route::middleware('localization')->namespace('API')->group(function () {

    // ===========================Auth routes=========================== //
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    // ===========================End Auth routes=========================== //




    Route::middleware('auth:sanctum')->group(function () {

        // ===========================Available Rooms routes=========================== //
        Route::get('available-rooms', [RoomController::class, 'index']);
        // ===========================End Available Rooms routes======================= //

        // ============================ Booking routes =========================== //
        Route::post('booking', [BookingController::class, 'store']);
        // ===========================End Booking routes=========================== //

        // =========================== Logout routes =========================== //
        Route::post('logout', 'UserController@logout');
        // =========================== End Logout routes =========================== //

    });
});
