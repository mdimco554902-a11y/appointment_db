<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Explicitly tell Laravel the table name
    protected $table = 'daily_schedules';
    
    protected $primaryKey = 'ScheduleID';

    protected $fillable = [
        'DoctorID',
        'AvailableDate',
        'Shift',
        'MaxCapacity',
        'CurrentBookings'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'DoctorID', 'DoctorID');
    }
}