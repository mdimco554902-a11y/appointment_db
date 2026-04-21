<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        // Creates the 3 doctors with IDs 1, 2, and 3
        $doctors = [
            [
                'DoctorID' => 1,
                'FirstName' => 'Dr. Gregory',
                'LastName' => 'House',
                'Specialization' => 'Diagnostic Medicine',
                'Email' => 'house@healthcare.com',
            ],
            [
                'DoctorID' => 2,
                'FirstName' => 'Dr. Meredith',
                'LastName' => 'Grey',
                'Specialization' => 'General Surgery',
                'Email' => 'grey@healthcare.com',
            ],
            [
                'DoctorID' => 3,
                'FirstName' => 'Dr. Shaun',
                'LastName' => 'Murphy',
                'Specialization' => 'Surgery',
                'Email' => 'murphy@healthcare.com',
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::updateOrCreate(['DoctorID' => $doctor['DoctorID']], $doctor);
        }
    }
}