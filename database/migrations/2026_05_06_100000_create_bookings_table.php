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
        Schema::create('booking_records', function (Blueprint $table) {
        $table->id('RecordID');
        $table->foreignId('PatientID')->constrained('patients', 'PatientID')->onDelete('cascade');
        $table->foreignId('AppointmentID')->constrained('appointments', 'AppointmentID')->onDelete('cascade');

        $table->foreignId('DoctorID')->constrained('doctors', 'DoctorID')->onDelete('cascade');
        $table->string('ServicePerformed'); 
        $table->text('AttendingDoctorNotes')->nullable(); 
        $table->date('VisitDate');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
