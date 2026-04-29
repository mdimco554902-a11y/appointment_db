<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Update 'FirstName' to 'FName' and 'LastName' to 'LName'
        Doctor::updateOrCreate(
            ['FName' => 'Sarah', 'LName' => 'Johnson'], 
            [
                'DeptID' => 1,
                'Specialization' => 'Cardiology',
                'MName' => null,
            ]
        );
    }
}