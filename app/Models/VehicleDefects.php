<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDefects extends Model
{
    use HasFactory;

    protected $fillable= [
        'vehicle_registration_number',
        'vehicle_make',
        'contact_number',
        'vehicle_number',
        'vehicle_type',
        'use_of_vehicle',
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
