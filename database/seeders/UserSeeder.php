<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. The Admin User
        // We identify this user as Admin in the Sidebar/Model by this specific email
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. The Customer User
        // This user will have limited access because their email is NOT admin@gmail.com
        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('customer123'),
            ]
        );
    }
}