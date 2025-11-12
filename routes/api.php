<?php

use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TableBookingScheduleController;
use App\Http\Controllers\TableFloorPlanController;
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


    /* CONTACT */
    Route::prefix('contact')->group(function() {
        Route::get('/', [ContactController::class, 'index']);
        Route::post('/', [ContactController::class, 'store']);
        Route::get('/{id}', [ContactController::class, 'view']);
        Route::post('/{id}', [ContactController::class, 'update']);
        Route::delete('/{id}', [ContactController::class, 'delete']);
    });
    Route::get('/contact-search/{search}', [ContactController::class, 'search']);
    Route::get('/contact-all', [ContactController::class, 'indexAll']);


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


    /* TABLE FLOOR PLAN */
    Route::prefix('table-floor-plan')->group(function() {
        Route::get('/', [TableFloorPlanController::class, 'index']);
        Route::post('/', [TableFloorPlanController::class, 'store']);
        Route::get('/{id}', [TableFloorPlanController::class, 'view']);
        Route::post('/{id}', [TableFloorPlanController::class, 'update']);
        Route::delete('/{id}', [TableFloorPlanController::class, 'delete']);
    });
    Route::get('/table-floor-plan-by-floor', [TableFloorPlanController::class, 'indexByFloor']);
    Route::get('/table-floor-plan-search/{search}', [TableFloorPlanController::class, 'search']);
    Route::get('/table-floor-plan-search-all/{search}', [TableFloorPlanController::class, 'searchAll']);
    Route::get('/table-floor-plan-all', [TableFloorPlanController::class, 'indexAll']);
    Route::get('/table-floor-plan-all-with-booking', [TableFloorPlanController::class, 'indexAllWithBooking']);
    Route::post('/table-floor-plan-store-all', [TableFloorPlanController::class, 'storeAll']);


    Route::prefix('table-booking-schedule')->group(function() {
        Route::post('/', [TableBookingScheduleController::class, 'store']);
        Route::get('/{id}', [TableBookingScheduleController::class, 'view']);
        Route::post('/{id}', [TableBookingScheduleController::class, 'update']);
        Route::delete('/{id}', [TableBookingScheduleController::class, 'delete']);
    });
    Route::get('/table-booking-schedule-by-date-time', [TableBookingScheduleController::class, 'indexByDateTime']);
    Route::get('/table-booking-schedule-by-floor-date', [TableBookingScheduleController::class, 'indexByFloorDate']);
    Route::get('/table-booking-schedule-by-floor-time', [TableBookingScheduleController::class, 'indexByFloorTime']);
    Route::get('/table-booking-schedule-by-date', [TableBookingScheduleController::class, 'indexByDate']);
    Route::get('/table-booking-schedule-by-status', [TableBookingScheduleController::class, 'indexByStatus']);

});
