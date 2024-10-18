<?php

use App\Models\BedModel;
use App\Models\Patient;
use App\Models\PatientCare;
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
        Schema::create('bed_occupation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BedModel::class, 'bed_model_id')->constrained();
            $table->foreignIdFor(PatientCare::class, 'patient_care_id')->constrained();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_occupied')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed_occupation_histories');
    }
};
