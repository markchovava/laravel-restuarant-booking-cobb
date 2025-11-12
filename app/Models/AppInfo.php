<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppInfo extends Model
{
    protected $fillable = [
        'id',
        'userId',
        'name',
        'phone',
        'email',
        'website',
        'address',
        'whatsapp',
        'facebook',
        'description',
        'created_at',
        'updated_at',
    ];


    public function user(){
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    
}
