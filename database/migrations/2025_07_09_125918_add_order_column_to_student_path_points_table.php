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
        Schema::table('student_path_progress', function (Blueprint $table) {
            $table->integer('order')->default(1)->after('path_point_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_path_progress', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
