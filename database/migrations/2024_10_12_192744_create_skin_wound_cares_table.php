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
        Schema::create('skin_wound_cares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id_care')->constrained();
            $table->string('wound_dressings')->nullable();
            $table->string('drain_output')->nullable();
            $table->string('skin_integrity')->nullable();
            $table->dateTime('date_of_care');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skin_wound_cares');
    }
};
