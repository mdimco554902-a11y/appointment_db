<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $primaryKey = 'AppointmentID'; // Tell Laravel the ID name

    // This "fillable" list allows the Save button to actually send data to DB
    protected $fillable = [
        'PatientID', 
        'DoctorID', 
        'ScheduleID', 
        'AppointmentTime', 
        'Status'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class, 'DoctorID', 'DoctorID');
    }
}