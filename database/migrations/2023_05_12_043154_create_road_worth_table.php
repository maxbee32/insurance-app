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
        Schema::create('road_worths', function (Blueprint $table) {
            $table->id();
            $table->string('roadworth_id');
            $table->string('vehicle_registration_number');
            $table->string('owner_surname');
            $table->string('owner_othername');
            $table->string('phone_number');
            $table->string('vehicle_cc');
            $table->string('vehicle_make');
            $table->string('use_of_vehicle');
            $table->date('date_of_inspection');
            $table->date('next_inspection_date');
            $table->string('amount');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('road_worths');
    }
};
