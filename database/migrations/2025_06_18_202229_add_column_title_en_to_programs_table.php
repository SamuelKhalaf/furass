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
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
        Schema::table('programs', function (Blueprint $table) {
            $table->string('title_ar')->after('id');
            $table->string('title_en')->after('title_ar');
            $table->string('description_ar')->after('title_en');
            $table->string('description_en')->after('description_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('title_ar');
            $table->dropColumn('title_en');
            $table->dropColumn('description_ar');
            $table->dropColumn('description_en');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('description')->after('title');
        });
    }
};
