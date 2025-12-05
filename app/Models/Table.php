<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'id',
        'userId',
        'locationId',
        'name',
        'seats',
        'quantity',
        'status',
        'created_at',
        'updated_at',
    ];

    public function location() {
        return $this->belongsTo(Location::class, 'locationId', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

}
