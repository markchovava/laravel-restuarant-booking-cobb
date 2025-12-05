<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'id',
        'userId',
        'name',
        'slug',
        'status',
        'description',
        'tablesTotal',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function tables(){
        return $this->hasMany(Table::class, 'locationId', 'id');
    }

}
