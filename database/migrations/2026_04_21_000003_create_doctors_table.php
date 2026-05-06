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
            $table->id('DoctorID');
            $table->string('FirstName', 50);
            $table->string('MiddleName', 50)->nullable(); 
            $table->string('LastName', 50);
            $table->string('Specialization', 100);
            $table->unsignedBigInteger('DeptID');
            // Foreign Key Constraint
            $table->foreign('DeptID')->references('DeptID')->on('departments')->onDelete('cascade');
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