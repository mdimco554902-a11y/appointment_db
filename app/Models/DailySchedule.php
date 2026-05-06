<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailySchedule extends Model
{
    // Explicitly define the table name and primary key
    protected $table = 'daily_schedules';
    protected $primaryKey = 'ScheduleID';

    // This list tells Laravel it is SAFE to save data into these columns
    protected $fillable = [
        'DoctorID', 
        'AvailableDate', 
        'Shift', 
        'MaxCapacity', 
        'CurrentBookings'
    ];

    /**
     * Relationship to the Doctor
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'DoctorID', 'DoctorID');
    }
}