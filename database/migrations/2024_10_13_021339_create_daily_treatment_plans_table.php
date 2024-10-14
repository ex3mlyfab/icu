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
        Schema::create('daily_treatment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained();
            $table->string('daily_treatment_plan');
            $table->foreignId('created_by')->constrained('users');
            $table->dateTime('time_of_daily_treatment_plan');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_treatment_plans');
    }
};
