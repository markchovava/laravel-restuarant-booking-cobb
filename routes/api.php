<?php

use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleBookingController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function() {
    
    /* PROFILE */
    Route::prefix('profile')->group(function() {
        Route::get('/', [AuthController::class, 'view']);
        Route::post('/', [AuthController::class, 'update']);
    });
    Route::post('/password', [AuthController::class, 'password']);
    Route::post('/email', [AuthController::class, 'email']);
    Route::get('/logout', [AuthController::class, 'logout']);
    
    /* APPINFO */
    Route::prefix('app-info')->group(function() {
        Route::get('/', [AppInfoController::class, 'view']);
        Route::post('/', [AppInfoController::class, 'store']);
    }); 

    /* BOOKING */
    Route::prefix('booking')->group(function() { 
        Route::get('/', [BookingController::class, 'index']);
        Route::post('/', [BookingController::class, 'store']);
        Route::get('/{id}', [BookingController::class, 'view']);
        Route::post('/{id}', [BookingController::class, 'update']);
        Route::delete('/{id}', [BookingController::class, 'delete']);
    });
    Route::post('/booking-status/{id}', [BookingController::class, 'updateStatus']);
    Route::get('/booking-search', [BookingController::class, 'search']);

    /* SCHEDULE */
    Route::prefix('schedule')->group(function() { 
        Route::get('/', [ScheduleController::class, 'index']);
        Route::get('/{id}', [ScheduleController::class, 'view']);
    });
    Route::get('schedule-delete', [ScheduleController::class, 'delete']);
    Route::post('/schedule-status/{id}', [ScheduleController::class, 'updateStatus']);
    Route::post('/schedule-admin', [ScheduleController::class, 'storeAdminSchedule']);
    Route::get('/schedule-search', [ScheduleController::class, 'search']);
    Route::get('/schedule-by-date-time', [ScheduleController::class, 'indexByDateTime']);

    /* SCHEDULE BOOKING */
    Route::prefix('schedule-booking')->group(function() {
        Route::get('/', [ScheduleBookingController::class, 'index']);
        Route::post('/', [ScheduleBookingController::class, 'store']);
        Route::get('/{id}', [ScheduleBookingController::class, 'view']);
        Route::post('/{id}', [ScheduleBookingController::class, 'update']);
        Route::delete('/{id}', [ScheduleBookingController::class, 'delete']);
    });
    Route::post('/schedule-booking-status/{id}', [ScheduleBookingController::class, 'updateStatus']);
    Route::get('/schedule-booking-search', [ScheduleBookingController::class, 'search']);
    Route::get('/schedule-booking-all', [ScheduleBookingController::class, 'indexAll']);
    

    /* LOCATION */
    Route::prefix('location')->group(function() {
        Route::get('/', [LocationController::class, 'index']);
        Route::post('/', [LocationController::class, 'store']);
        Route::get('/{id}', [LocationController::class, 'view']);
        Route::post('/{id}', [LocationController::class, 'update']);
        Route::delete('/{id}', [LocationController::class, 'delete']);
    });
    Route::get('/location-search', [LocationController::class, 'search']);
    Route::get('/location-all', [LocationController::class, 'indexAll']);
    

    /* TABLE */
    Route::prefix('table')->group(function() {
        Route::get('/', [TableController::class, 'index']);
        Route::post('/', [TableController::class, 'store']);
        Route::get('/{id}', [TableController::class, 'view']);
        Route::post('/{id}', [TableController::class, 'update']);
        Route::delete('/{id}', [TableController::class, 'delete']);
    });
    Route::get('/table-search', [TableController::class, 'search']);
    Route::get('/table-by-location-id/{id}', [TableController::class, 'indexByLocationId']);
    Route::get('/table-all', [TableController::class, 'indexAll']);
    
    /* USER */
    Route::prefix('user')->group(function() {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'view']);
        Route::post('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
    });
    Route::get('/user-search/{search}', [UserController::class, 'search']);
    Route::get('/user-all', [UserController::class, 'indexAll']);


});
