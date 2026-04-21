<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySchedule extends Model
{
    protected $primaryKey = 'ScheduleID';
    protected $fillable = ['DoctorID', 'AvailableDate', 'MaxCapacity', 'CurrentBookings'];

    public function doctor() {
        return $this->belongsTo(Doctor::class, 'DoctorID');
    }
}