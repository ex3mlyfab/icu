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
        Schema::create('physician_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_care_id')->constrained('patient_cares');
            $table->string('name');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_discontinued')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physician_orders');
    }
};
