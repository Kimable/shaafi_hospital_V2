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
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ["lab_result", "prescription", "vaccination", "medical_report"]);
            $table->string('title');
            $table->string('date');
            $table->string('doctor_name');
            $table->text('description');
            $table->string('file_url')->nullable();
            $table->string('doctor_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('health_records', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};
