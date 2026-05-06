<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Service; 
use App\Models\DailySchedule;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a Department first (The parent table)
        $dept = Department::updateOrCreate(
            ['DepartmentName' => 'Cardiology'],
            ['Description' => 'Heart and vascular disorders and treatments.']
        );

        // 2. Create a Doctor linked to that Department
        $doctor = Doctor::updateOrCreate(
            ['Firstname' => 'Sarah', 'LastName' => 'Johnson'],
            [
                'MiddleName' => null,
                'Specialization' => 'Cardiology',
                'DeptID' => $dept->DeptID
            ]
        );

        // 3. Seed Services
        Service::updateOrCreate(
            ['ServiceName' => 'Heart Checkup'],
            [
                'DeptID' => $dept->DeptID, 
                'Description' => 'Comprehensive cardiovascular screening and diagnostics.'
            ]
        );

        Service::updateOrCreate(
            ['ServiceName' => 'ECG/EKG Scan'],
            [
                'DeptID' => $dept->DeptID,
                'Description' => 'Electrocardiogram to monitor heart rhythm and activity.'
            ]
        );

        // 4. Seed Daily Schedules (Matches your migration MaxCapacity)
        DailySchedule::updateOrCreate(
            [
                'DoctorID' => $doctor->DoctorID, 
                'AvailableDate' => '2026-05-10'
            ],
            [
                'Shift' => 'AM',
                'MaxCapacity' => 10,
                'CurrentBookings' => 0
            ]
        );

        DailySchedule::updateOrCreate(
            [
                'DoctorID' => $doctor->DoctorID, 
                'AvailableDate' => '2026-05-11'
            ],
            [
                'Shift' => 'PM',
                'MaxCapacity' => 15,
                'CurrentBookings' => 0
            ]
        );

        // 5. Call external seeders
        $this->call([
            UserSeeder::class,
            // Add PatientSeeder here if you have one, so you have patients to book!
        ]);
    }
}