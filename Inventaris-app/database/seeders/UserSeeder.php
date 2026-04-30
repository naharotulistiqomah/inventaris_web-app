<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('admin_superadmin'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Manager',
        'email' => 'manager@gmail.com',
        'password' => Hash::make('manager_first'),
        'role' => 'manager',
    ]);

    User::create([
        'name' => 'Staff',
        'email' => 'staff@gmail.com',
        'password' => Hash::make('staff_staff1'),
        'role' => 'staff',
    ]);
    }
}
