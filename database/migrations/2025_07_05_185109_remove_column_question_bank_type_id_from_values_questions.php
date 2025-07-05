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
        Schema::table('values_questions', function (Blueprint $table) {
            $table->dropColumn('question_bank_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('values_questions', function (Blueprint $table) {
            $table->bigInteger('question_bank_type_id');
        });
    }
};
