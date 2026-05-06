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
    Schema::create('daily_schedules', function (Blueprint $table) {
        $table->id('ScheduleID');
        $table->unsignedBigInteger('DoctorID');
        $table->date('AvailableDate');
        // Ensure this column is here and spelled correctly
        $table->enum('Shift', ['AM', 'PM', 'Full Day'])->default('Full Day');
        $table->integer('MaxCapacity'); 
        $table->integer('CurrentBookings')->default(0);
        
        $table->foreign('DoctorID')->references('DoctorID')->on('doctors')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_schedules');
    }
};