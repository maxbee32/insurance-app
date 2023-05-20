<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleDefects extends Model
{
    use HasFactory;

    protected $guarded= [];
    //     'vehicle_defects',
    //     'number',
    //     'remarks'
    // ];


    public function user()
    {
        return $this->belongsTo(RoadWorth::class,'r_id');
    }
}


