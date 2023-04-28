<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable= [
        'insurance_company',
        'name_of_insurer',
        'phone_number',
        'vehicle_number',
        'vehicle_type',
        'use_of_vehicle',
        'cover_type',
        'inception_date',
        'expiring_date',
        'premium',
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
