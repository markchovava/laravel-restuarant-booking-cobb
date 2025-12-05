<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'id',
        'userId',
        'locationId',
        'scheduleId',
        'scheduleBookingId',
        'tableId',
        'bookingRef',
        'tableName',
        'locationName',
        'fullName',
        'phone',
        'email',
        'guests',
        'date',
        'time',
        'notes',
        'updated_at',
        'created_at',
    ];

    public function schedule(){
        return $this->belongsTo(Schedule::class, 'scheduleId', 'id');
    }

    public function scheduleBooking(){
        return $this->belongsTo(ScheduleBooking::class, 'scheduleBookingId', 'id');
    }

    public function table(){
        return $this->belongsTo(Table::class, 'tableId', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'locationId', 'id');
    }

}
