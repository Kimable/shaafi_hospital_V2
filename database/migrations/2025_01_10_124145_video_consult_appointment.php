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
        Schema::create('video_consult', function (Blueprint $table) {
            $table->id();
            $table->text('date');
            $table->string('time');
            $table->text('medical_issue');
            $table->string('appointment_code');
            $table->string('booked_doctor_id')->default(0);
            $table->string('payment_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('video_consult', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
