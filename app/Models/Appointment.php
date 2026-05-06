<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $primaryKey = 'AppointmentID';
    protected $fillable = [
        'PatientID', 'DoctorID', 'ScheduleID', 'ServiceID', 
        'PriorityNumber', 'BookingReason', 'Shift', 'AppointmentTime', 'Status'
    ];

    // This is what fixes the "N/A" in your table
    public function dailySchedule(): BelongsTo
    {
        return $this->belongsTo(DailySchedule::class, 'ScheduleID', 'ScheduleID');
    }

    public function patient(): BelongsTo { return $this->belongsTo(Patient::class, 'PatientID', 'PatientID'); }
    public function doctor(): BelongsTo { return $this->belongsTo(Doctor::class, 'DoctorID', 'DoctorID'); }
    public function service(): BelongsTo { return $this->belongsTo(Service::class, 'ServiceID', 'ServiceID'); }
}