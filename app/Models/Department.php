<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'DeptID';

    // Must match the column name in your database exactly
    protected $fillable = ['DepartmentName', 'Description'];

    public function doctors() {
        return $this->hasMany(Doctor::class, 'DeptID');
    }
}