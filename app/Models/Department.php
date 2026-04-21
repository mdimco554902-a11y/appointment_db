<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'DeptID';
    protected $fillable = ['DepartmentName', 'Description'];

    public function doctors() {
        return $this->hasMany(Doctor::class, 'DeptID');
    }
}