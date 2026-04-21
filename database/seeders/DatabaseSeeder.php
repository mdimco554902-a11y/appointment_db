<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Doctor;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Department first (The parent table)
        $dept = Department::updateOrCreate(
            ['DepartmentName' => 'Cardiology'],
            ['Description' => 'Heart and Vascular Center']
        );

        // 2. Create a Doctor linked to that Department
        Doctor::updateOrCreate(
            ['FirstName' => 'Sarah', 'LastName' => 'Johnson'],
            [
                'Specialization' => 'Cardiologist',
                'DeptID' => $dept->DeptID
            ]
        );

        // 3. Call the User Seeder for login credentials
        $this->call([
            UserSeeder::class,
        ]);
    }
}