<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'ressa@admintask.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Head',
            'email' => 'shan@headtask.com',
            'password' => Hash::make('123456'),
            'role' => 'head',
        ]);

        User::create([
            'name' => 'Staff',
            'email' => 'riri@stafftask.com',
            'password' => Hash::make('123456'),
            'role' => 'housekeeper',
        ]);
    }
}