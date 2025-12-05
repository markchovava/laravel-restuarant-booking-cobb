<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'id',
        'userId',
        'locationId',
        'locationName',
        'status',
        'date',
        'time',
        'description',
        'tablesTotal',
        'tablesTaken',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'locationId', 'id');
    }

    public function schedule_bookings(){
        return $this->belongsTo(ScheduleBooking::class, 'scheduleId', 'id');
    }

}
