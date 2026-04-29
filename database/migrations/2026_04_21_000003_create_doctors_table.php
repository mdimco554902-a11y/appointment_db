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
            $table->id('DoctorID'); 
            
            // Link to the departments table
            $table->unsignedBigInteger('DeptID'); 
            
            // Use FName/LName to match your Controller/Model logic
            $table->string('FName');
            $table->string('MName')->nullable();
            $table->string('LName');
            $table->string('Specialization');
            
            $table->timestamps();

            // Setup the foreign key relationship
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