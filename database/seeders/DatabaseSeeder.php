<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Doctor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a Department first (The parent table)
        // Ensure 'DepartmentName' matches your migration column exactly
        $dept = Department::updateOrCreate(
            ['DepartmentName' => 'Cardiology'],
            ['Description' => 'Heart and vascular disorders and treatments.']
        );

        // 2. Create a Doctor linked to that Department
        // CHANGED: Use 'FName' and 'LName' to match your updated migration
        Doctor::updateOrCreate(
            ['FName' => 'Sarah', 'LName' => 'Johnson'],
            [
                'MName' => null,
                'Specialization' => 'Cardiology',
                'DeptID' => $dept->DeptID
            ]
        );

        // 3. Call the User Seeder for login credentials
        $this->call([
            UserSeeder::class,
        ]);
    }
}