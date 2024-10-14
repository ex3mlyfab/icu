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
        Schema::create('infusionand_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained();
            $table->string('infusion');
            $table->string('frequency');
            $table->string('rate');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infusionand_rates');
    }
};
