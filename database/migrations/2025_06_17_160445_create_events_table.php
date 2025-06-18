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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->string('event_name');
            $table->string('company_name');
            $table->string('location');
            $table->dateTime('event_time');
            $table->enum('content_type', ['pdf', 'video', 'text']);
            $table->string('content_path')->nullable();
            $table->enum('event_type', ['trip', 'workshop'])->default('trip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
