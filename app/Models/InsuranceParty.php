<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceParty extends Model
{
    use HasFactory;

    protected $fillable= [
        'insurance_company',
        'registrationId',
        'surname',
        'othername',
        'gender',
        'dob',
        'phone_number',
        'vehicle_number',
        'vehicle_model',
        'vehicle_make',
        'vehicle_color',
        'vehicle_fuel_type',
        'vehicle_mileage',
        'vehicle_registered_date',
        'vehicle_type',
        'vehicle_no_seat',
        'vehicle_no_doors',
        'vehicle_transmission',
        'vehicle_engine_type',
        'vehicle_identification_number',
        'record_of_past_ownership',
        'vehicle_chassis_number',
        'use_of_vehicle',
        'cover_type',
        'inception_date',
        'expiring_date',
    ];

}
