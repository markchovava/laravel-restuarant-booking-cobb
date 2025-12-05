<?php
use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleBookingController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/', [AppInfoController::class, 'view']);

/* CONTACT */
Route::post('/contact', [ContactController::class, 'store']);


/* APP INFORMATION */
Route::prefix('app-info')->group(function() {
    Route::get('/', [AppInfoController::class, 'view']);
}); 

   
/* APPINFO */
Route::prefix('app-info')->group(function() {
    Route::get('/', [AppInfoController::class, 'view']);
}); 

/* BOOKING */
Route::prefix('booking')->group(function() {
    Route::get('/', [BookingController::class, 'index']);
    Route::post('/', [BookingController::class, 'store']);
    Route::get('/{id}', [BookingController::class, 'view']);
});
Route::get('/booking-search', [BookingController::class, 'search']);
Route::get('/booking-all', [BookingController::class, 'indexAll']);


/* SCHEDULE */
Route::get('/schedule/{id}', [ScheduleController::class, 'view']);
Route::get('/schedule-by-date-time', [ScheduleController::class, 'indexByDateTime']);


/* SCHEDULE BOOKING */
Route::prefix('schedule-booking')->group(function() {
    Route::get('/', [ScheduleBookingController::class, 'index']);
    Route::post('/', [ScheduleBookingController::class, 'store']);
    Route::get('/{id}', [ScheduleBookingController::class, 'view']);
});
Route::get('/schedule-booking-search/{search}', [ScheduleBookingController::class, 'search']);
Route::get('/schedule-booking-by-date-time-schedule', [ScheduleBookingController::class, 'indexByDateTimeSchedule']);
   

/* LOCATION */
Route::prefix('location')->group(function() {
    Route::get('/', [LocationController::class, 'index']);
    Route::get('/{id}', [LocationController::class, 'view']);
});
Route::get('/location-search/{search}', [LocationController::class, 'search']);
Route::get('/location-all', [LocationController::class, 'indexAll']);


/* TABLE */
Route::prefix('table')->group(function() {
    Route::get('/', [TableController::class, 'index']);
    Route::get('/{id}', [TableController::class, 'view']);
});
Route::get('/table-search', [TableController::class, 'search']);
Route::get('/table-all', [TableController::class, 'indexAll']);


