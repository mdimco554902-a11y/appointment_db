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
        Schema::create('patients', function (Blueprint $blueprint) {
            // Primary Key
            $blueprint->id('PatientID'); 

            // Personal Information
            $blueprint->string('FirstName');
            $blueprint->string('MiddleName')->nullable();
            $blueprint->string('LastName');
            
            // Contact Information
            $blueprint->string('Email')->unique();
            $blueprint->string('Phone')->nullable();
            
            // Medical/Demographic Info (Matching your Controller)
            $blueprint->integer('Age')->nullable();
            $blueprint->date('BirthDate')->nullable();
            $blueprint->string('Gender', 20)->nullable();
            $blueprint->decimal('Height', 5, 2)->nullable(); // Up to 999.99
            $blueprint->string('BloodType', 5)->nullable();
            $blueprint->text('Address')->nullable();

            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};