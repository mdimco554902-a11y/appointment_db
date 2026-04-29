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
     * These match the input names in your index.blade.php form.
     */
    protected $fillable = [
        'DeptID', 
        'FName', 
        'MName', 
        'LName', 
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
     * Optional: Helper to get full name easily in views
     * Usage: $doc->full_name
     */
    public function getFullNameAttribute()
    {
        return "Dr. {$this->FName} " . ($this->MName ? "{$this->MName} " : "") . $this->LName;
    }
}