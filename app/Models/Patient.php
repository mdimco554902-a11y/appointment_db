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
        'MiddleName', // Added MiddleName to match database design
        'LastName',
        'Email',
        'Phone',
        'DateOfBirth',
        'Address'
    ];

    /**
     * The attributes that should be cast.
     * This ensures DateOfBirth is treated as a Carbon date object.
     */
    protected $casts = [
        'DateOfBirth' => 'date',
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