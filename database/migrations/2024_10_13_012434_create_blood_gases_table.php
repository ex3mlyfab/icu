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
        Schema::create('blood_gases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained();
            $table->smallInteger('pco2');
            $table->smallInteger('po2');
            $table->smallInteger('hco3');
            $table->smallInteger('etco2');
            $table->smallInteger('pcv');
            $table->smallInteger('wbc');
            $table->smallInteger('platelets');
            $table->smallInteger('blood_glucose');
            $table->smallInteger('creatinine');
            $table->smallInteger('ph');
            $table->smallInteger('sodium');
            $table->smallInteger('potassium');
            $table->smallInteger('urea');
            $table->smallInteger('hemoglobin');
            $table->dateTime('time_of_blood_gases');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_gases');
    }
};
