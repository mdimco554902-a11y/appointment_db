<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    // Specifies the custom primary key used in your migration
    protected $primaryKey = 'PatientID';

    // Allows mass assignment for these specific fields
    protected $fillable = [
        'FirstName',
        'MiddleName', 
        'LastName',
        'Email',
        'Phone',
        'Age',
        'BirthDate', // Corrected from DateOfBirth to match migration
        'Gender',    // Added new clinical field
        'Height',    // Added new clinical field
        'BloodType', // Added new clinical field
        
        'Address'
    ];

    /**
     * The attributes that should be cast.
     * This ensures BirthDate is treated as a Carbon date object.
     */
    protected $casts = [
        'BirthDate' => 'date', // Corrected name to match database
    ];

    /**
     * Relationship: A patient can have many appointments.
     * Ensure the foreign key matches the 'PatientID' column in your appointments table.
     */
    public function appointments() 
    {
        return $this->hasMany(Appointment::class, 'PatientID', 'PatientID');
    }
}