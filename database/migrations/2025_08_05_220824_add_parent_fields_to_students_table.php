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
        Schema::table('students', function (Blueprint $table) {
            $table->string('parent_name')->nullable()->after('gender');
            $table->string('parent_phone')->nullable()->after('parent_name');
            $table->tinyInteger('parent_relationship')->nullable()->after('parent_phone')
                ->comment('1=Father, 2=Mother, 3=Sibling, 4=Other');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['parent_name', 'parent_phone', 'parent_relationship']);
        });
    }
};
