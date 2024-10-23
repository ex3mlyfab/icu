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
        Schema::create('neuro_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained();
            $table->smallInteger('eyes_open');
            $table->boolean('sedated')->default(0);
            $table->smallInteger('best_verbal_response');
            $table->boolean('intubated')->default(0);
            $table->smallInteger('best_motor_response');
            $table->boolean('muscle_relaxant')->default(0);
            $table->smallInteger('sedation_score');
            $table->smallInteger('pupil_diameter')->nullable();
            $table->time('hour_taken');
            $table->dateTime('time_of_neuro_assessment');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neuro_assessments');
    }
};
