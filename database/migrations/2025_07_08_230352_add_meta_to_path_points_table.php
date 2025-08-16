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
        Schema::table('path_points', function (Blueprint $table) {
            $table->json('meta')->nullable()->after('table_name')->comment('Flexible JSON data for extra config');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('path_points', function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
};
