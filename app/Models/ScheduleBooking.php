<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleBooking extends Model
{
    protected $fillable = [
        'id',
        'userId',
        'scheduleId',
        'locationId',
        'tableId',
        'locationName',
        'tableName',
        'quantity',
        'taken',
        'date',
        'time',
        'status',
        'created_at',
        'updated_at',
    ];


    public function location() {
        return $this->belongsTo(Location::class, 'locationId', 'id');
    }

    public function table() {
        return $this->belongsTo(Table::class, 'tableId', 'id');
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class, 'scheduleId', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    
}
