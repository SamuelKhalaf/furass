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
        Schema::create('sub_admin_school', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_admin_id');
            $table->unsignedBigInteger('school_id');

            // Foreign keys
            $table->foreign('sub_admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_admin_school');
    }
};
