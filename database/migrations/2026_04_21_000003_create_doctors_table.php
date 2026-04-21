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
    Schema::create('doctors', function (Blueprint $table) {
        $table->id('DoctorID'); // This creates the primary key
        $table->string('FirstName');
        $table->string('LastName');
        $table->string('Specialization');
        $table->string('Email')->unique(); // Add this line if it's missing
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};