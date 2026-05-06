<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('AppointmentID');
            
            // Ensure these match the 'id' type of their respective tables
            $table->unsignedBigInteger('PatientID');
            $table->unsignedBigInteger('DoctorID');
            $table->unsignedBigInteger('ScheduleID');
            $table->unsignedBigInteger('ServiceID');
            
            $table->integer('PriorityNumber')->default(0);
            $table->text('BookingReason')->nullable();
            $table->string('Shift');
            $table->time('AppointmentTime')->nullable();
            $table->string('Status')->default('Pending');

            // Foreign Key Constraints
            $table->foreign('PatientID')->references('PatientID')->on('patients')->onDelete('cascade');
            $table->foreign('DoctorID')->references('DoctorID')->on('doctors')->onDelete('cascade');
            $table->foreign('ScheduleID')->references('ScheduleID')->on('daily_schedules')->onDelete('cascade');
            $table->foreign('ServiceID')->references('ServiceID')->on('services')->onDelete('cascade');
            
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
