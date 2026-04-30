<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This table is now fully synchronized with the FirstName/LastName naming convention.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            // Primary Key
            $table->id('DoctorID'); 
            
            // Foreign Key to Departments
            $table->unsignedBigInteger('DeptID'); 
            
            // Professional Name Columns
            $table->string('FirstName');
            $table->string('MiddleName')->nullable(); // Optional field
            $table->string('LastName');
            
            // Professional Details
            $table->string('Specialization');
            
            // Standard timestamps (created_at, updated_at)
            $table->timestamps();

            // Foreign Key constraint
            $table->foreign('DeptID')
                  ->references('DeptID')
                  ->on('departments')
                  ->onDelete('cascade');
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