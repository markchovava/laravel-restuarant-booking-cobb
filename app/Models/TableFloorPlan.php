<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableFloorPlan extends Model
{
    
    protected $fillable = [
        'id',
        'userId',
        'name',
        'd',
        'details',
        'floor',
        'created_at',
        'updated_at'
    ];

    public function table_booking_schedules(){
        return $this->hasMany(TableBookingSchedule::class, 'tableFloorPlanId', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
