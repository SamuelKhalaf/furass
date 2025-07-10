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
        Schema::create('student_path_progress', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('path_point_id')->constrained()->onDelete('cascade');

            $table->unsignedTinyInteger('status')
                ->default(1)
                ->comment('1=locked, 2=active, 3=completed, 4=skipped');

            $table->dateTime('completion_date')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->unsignedInteger('attempt_count')->default(0);
            $table->unsignedInteger('time_spent')->default(0);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_path_progress');
    }
};
