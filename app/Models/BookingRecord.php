<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingRecord extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Based on your migration, the table is named 'booking_records'.
     */
    protected $table = 'booking_records';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'RecordID';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'PatientID', 
        'AppointmentID', 
        'DoctorID', 
        'ServicePerformed', 
        'AttendingDoctorNotes', 
        'VisitDate'
    ];

    /**
     * Relationship: The patient associated with this clinical record.
     */
    public function patient() 
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }

    /**
     * Relationship: The doctor who attended to the patient.
     */
    public function doctor() 
    {
        return $this->belongsTo(Doctor::class, 'DoctorID', 'DoctorID');
    }

    /**
     * Relationship: The original appointment that triggered this visit.
     */
    public function appointment() 
    {
        return $this->belongsTo(Appointment::class, 'AppointmentID', 'AppointmentID');
    }

    /**
     * UPDATED: Relationship to the Service model.
     * Links the 'ServicePerformed' string to the 'ServiceName' in the services table.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'ServicePerformed', 'ServiceName');
    }
}