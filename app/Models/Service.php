<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'ServiceID';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'DeptID', 
        'ServiceName', 
        'Description'
    ];

    /**
     * Relationship: Service belongs to a Department.
     * Connects DeptID in services table to DeptID in departments table.
     */
    public function department() 
    {
        return $this->belongsTo(Department::class, 'DeptID', 'DeptID');
    }

    /**
     * Relationship: Service can be offered by many Doctors.
     * Connects via the doctor_service pivot table.
     */
    public function doctors() 
    {
        return $this->belongsToMany(Doctor::class, 'doctor_service', 'ServiceID', 'DoctorID');
    }

    /**
     * UPDATED: Relationship for the clinical records where this service was performed.
     * Allows you to track service usage history.
     */
    public function bookingRecords()
    {
        // Note: We use 'ServicePerformed' as the foreign key because that is how 
        // you defined the column in your booking_records migration.
        return $this->hasMany(BookingRecord::class, 'ServicePerformed', 'ServiceName');
    }
}