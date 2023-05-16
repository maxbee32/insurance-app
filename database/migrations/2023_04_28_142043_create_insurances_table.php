<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('registrationid');
            $table->string('insurance_company');
            $table->string('surname');
            $table->string('othername');
            $table->string('gender');
            $table->date('dob');
            $table->string('phone_number');
            $table->string('vehicle_number');
            $table->string('vehicle_model');
            $table->string('vehicle_make');
            $table->string('vehicle_color');
            $table->string('vehicle_fuel_type');
            $table->string('vehicle_mileage');
            $table->date('vehicle_registered_date');
            $table->string('vehicle_type');
            $table->string('vehicle_no_seat');
            $table->string('vehicle_no_doors');
            $table->string('vehicle_transmission');
            $table->string('vehicle_engine_type');
            $table->string('vehicle_identification_number');
            $table->string('record_of_past_ownership');
            $table->string('vehicle_chassis_number');
            $table->string('use_of_vehicle');
            $table->string('cover_type');
            $table->date('inception_date');
            $table->date('expiring_date');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
