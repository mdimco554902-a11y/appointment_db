<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Service::create([
        'DeptID' => 1, // Ensure Dept ID 1 exists
        'ServiceName' => 'General Consultation',
        'Description' => 'Standard health checkup'
    ]);

    \App\Models\Service::create([
        'DeptID' => 2, 
        'ServiceName' => 'Cardiology Exam',
        'Description' => 'Heart related diagnostics'
    ]);
}
}
