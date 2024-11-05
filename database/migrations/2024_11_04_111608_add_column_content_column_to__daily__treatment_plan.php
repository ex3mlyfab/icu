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
        Schema::table('daily_treatment_plans', function (Blueprint $table) {
            $table->text('content')->nullable();
        });
        Schema::table('progress_notes', function (Blueprint $table) {
            $table->text('content')->nullable();
            $table->string('type')->nullable();
        });
        Schema::table('physician_orders', function (Blueprint $table) {
            $table->text('content')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_treatment_plans', function (Blueprint $table) {
            $table->dropColumn('content');
        });
        Schema::table('progress_notes', function (Blueprint $table) {
            $table->dropColumn('content');
        });
        Schema::table('physician_orders', function (Blueprint $table) {
            $table->dropColumn('content');
        });
    }


};
