<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'DoctorID';

    protected $fillable = [
        'DoctorID', // Allow setting ID manually for seeding
        'FirstName',
        'LastName',
        'Specialization',
        'Email'
    ];
}