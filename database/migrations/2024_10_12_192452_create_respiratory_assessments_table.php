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
        Schema::create('respiratory_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained();
            $table->string('mode_of_ventilation');
            $table->smallInteger('fi02')->nullable();
             $table->smallInteger('spo2')->nullable();
            $table->smallInteger('peep')->nullable();
            $table->smallInteger('patient_tidal_volume')->nullable();
            $table->smallInteger('ventilator_set_rate')->nullable();
            $table->smallInteger('ph_score')->nullable();
            $table->string('presuure_support');
            $table->smallInteger('total_expired_volume')->nullable();
            $table->time('hour_taken');
            $table->dateTime('time_of_respiratory_assessment');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respiratory_assessments');
    }
};
