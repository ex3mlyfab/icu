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
        Schema::create('hand_over_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('activity');
            $table->foreignId('morning_duty')->constrained('users');
            $table->foreignId('afternoon_duty')->constrained('users')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hand_over_checklists');
    }
};
