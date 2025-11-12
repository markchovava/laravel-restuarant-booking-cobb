<?php
use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TableBookingScheduleController;
use App\Http\Controllers\TableFloorPlanController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/', [AppInfoController::class, 'view']);

/* APP INFORMATION */
Route::prefix('app-info')->group(function() {
    Route::get('/', [AppInfoController::class, 'view']);
}); 


/* CONTACT */
Route::prefix('contact')->group(function() {
    Route::get('/', [ContactController::class, 'index']);
    Route::post('/', [ContactController::class, 'store']);
    Route::get('/{id}', [ContactController::class, 'view']);
});
Route::get('/contact-search/{search}', [ContactController::class, 'search']);
Route::get('/contact-all', [ContactController::class, 'indexAll']);


/* TABLE BOOKING SCHEDULE */
Route::prefix('table-booking-schedule')->group(function() {
    Route::get('/', [TableBookingScheduleController::class, 'index']);
    Route::post('/', [TableBookingScheduleController::class, 'store']);
    Route::get('/{id}', [TableBookingScheduleController::class, 'view']);
    Route::post('/{id}', [TableBookingScheduleController::class, 'update']);
});
Route::get('/table-booking-schedule-by-date-time', [TableBookingScheduleController::class, 'indexByDateTime']);
Route::get('/table-booking-schedule-by-floor-date', [TableBookingScheduleController::class, 'indexByFloorDate']);
Route::get('/table-booking-schedule-by-floor-time', [TableBookingScheduleController::class, 'indexByFloorTime']);
Route::get('/table-booking-schedule-by-date', [TableBookingScheduleController::class, 'indexByDate']);
Route::get('/table-booking-schedule-by-status', [TableBookingScheduleController::class, 'indexByStatus']);


Route::prefix('table-floor-plan')->group(function() {
    Route::get('/', [TableFloorPlanController::class, 'index']);
    Route::get('/{id}', [TableFloorPlanController::class, 'view']);
});
Route::get('/table-floor-plan-by-floor', [TableFloorPlanController::class, 'indexByFloor']);
Route::get('/table-floor-plan-search/{search}', [TableFloorPlanController::class, 'search']);
Route::get('/table-floor-plan-search-all/{search}', [TableFloorPlanController::class, 'searchAll']);
Route::get('/table-floor-plan-all', [TableFloorPlanController::class, 'indexAll']);
Route::get('/table-floor-plan-all-with-booking', [TableFloorPlanController::class, 'indexAllWithBooking']);




