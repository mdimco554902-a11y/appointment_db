<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
       
        Doctor::updateOrCreate(
            ['FirstName' => 'Sarah', 'LastName' => 'Johnson'], 
            [
                'DeptID' => 1,
                'Specialization' => 'Cardiology',
                'MiddleName' => null,
            ]
        );
    }
}