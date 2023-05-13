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
        Schema::create('road_worth', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('insurance_id');
            $table->string('brakes');
            $table->string('coupling_devices');
            $table->string('lights');
            $table->string('horn');
            $table->string('mirrors');
            $table->string('seatbelts');
            $table->string('steering_mechanism');
            $table->string('tyres');
            $table->string('windsheild_wipers');
            $table->string('engine_oil_level');
            $table->string('first_aid_kit');
            $table->string('flashlight');
            $table->string('spare_fuses');
            $table->string('jack');
            $table->string('warning_triangles');
            $table->string('spare_tyre');
            $table->timestamps();

            $table->foreign('insurance_id')
            ->references('id')->on('insurances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('road_worth');
    }
};
