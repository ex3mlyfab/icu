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
        Schema::create('cardio_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained('patient_cares');
            $table->smallInteger('heart_rate');
            $table->smallInteger('blood_pressure_systolic');
            $table->smallInteger('blood_pressure_diastolic');
            $table->smallInteger('temperature');
            $table->smallInteger('respiratory_rate')->nullable();
            $table->smallInteger('spo2')->nullable();
            $table->smallInteger('map')->nullable();
            $table->smallInteger('cvp')->nullable();
            $table->smallInteger('rhythm')->nullable();
            $table->smallInteger('peripheral_pulses')->nullable();
            $table->smallInteger('capillary_refill_time')->nullable();
            $table->dateTime('time_of_cardio_assessment')->nullable();
            $table->time('hour_taken');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cardio_assessments');
    }
};
