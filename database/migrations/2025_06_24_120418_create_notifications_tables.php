<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications' , function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('notification_targets',function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained()->onDelete('cascade');
            $table->morphs('target');
            $table->timestamps();
        });

        Schema::create('notification_statuses' , function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('notification_targets');
        Schema::dropIfExists('notification_statuses');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
