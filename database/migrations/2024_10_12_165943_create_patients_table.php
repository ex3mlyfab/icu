<?php

use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('hospital_no')->unique();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->string('hometown')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('tribe')->nullable();
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->string('occupation')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('next_of_kin_address')->nullable();
            $table->string('next_of_kin_telephone')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->smallInteger('gender')->default(GenderEnum::Female->value);
            $table->date('date_of_birth')->nullable();
            $table->smallInteger('marital_status')->default(MaritalStatusEnum::Single->value);
            $table->string('religion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
