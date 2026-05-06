<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'doctors';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'DoctorID';

    /**
     * The attributes that are mass assignable.
     * Updated to match your new professional column names.
     */
    protected $fillable = [
        'DeptID', 
        'FirstName', 
        'MiddleName', 
        'LastName', 
        'Specialization'
    ];

    /**
     * Get the department that owns the doctor.
     * Connects DeptID in doctors table to DeptID in departments table.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'DeptID', 'DeptID');
    }

    /**
     * UPDATED: Relationship for the services the doctor provides.
     * Connects via the doctor_service pivot table.
     */
    public function services() 
    {
        return $this->belongsToMany(Service::class, 'doctor_service', 'DoctorID', 'ServiceID');
    }

    /**
     * UPDATED: Relationship for the booking records associated with the doctor.
     */
    public function bookingRecords() 
    {
        return $this->hasMany(BookingRecord::class, 'DoctorID', 'DoctorID');
    }

    /**
     * Helper to get full name easily in views.
     * Updated to use the new column names.
     * Usage: $doc->full_name
     */
    public function getFullNameAttribute()
    {
        return "Dr. {$this->FirstName} " . ($this->MiddleName ? "{$this->MiddleName} " : "") . $this->LastName;
    }
}