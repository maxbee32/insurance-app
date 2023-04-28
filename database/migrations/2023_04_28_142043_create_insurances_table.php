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
            $table->string('insurance_company');
            $table->string('name_of_insurer');
            $table->string('phone_number');
            $table->string('vehicle_number');
            $table->string('vehicle_type');
            $table->string('use_of_vehicle');
            $table->string('cover_type');
            $table->date('inception_date');
            $table->date('expiring_date');
            $table->string('premium');
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
