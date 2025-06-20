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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->enum('status', ['pending', 'attended', 'skipped', 'evaluated'])
                  ->default('pending')->after('program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('enrollments', function (Blueprint $table) {
            $table->enum('status', ['active', 'completed', 'paused', 'cancelled'])
                  ->default('active');
        });
    }
};
