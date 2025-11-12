<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableBookingSchedule extends Model
{
    protected $fillable = [
        'id',
        'userId',
        'tableFloorPlanId',
        'date',
        'time',
        'status',
        'css',
        'fullName',
        'email',
        'numberOfGuests',
        'notes',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function table_floor_plan(){
        return $this->belongsTo(TableFloorPlan::class, 'tableFloorPlanId', 'id');
    }
    
}
