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
        Schema::create('patient_cares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->dateTime('admission_date');
            $table->string('diagnosis');
            $table->string('icu_consultant')->nullable();
            $table->string('admitted_from');
            $table->string('nurse_incharge');
            $table->boolean('ready_for_discharge')->default(0);
            $table->dateTime('discharge_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('bed_model_id')->constrained('bed_models');
            $table->foreignId('created_by')->constrained('users');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_cares');
    }
};
