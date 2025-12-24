<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '9876543210',
            'alt_phone' => '9876543211',
            'address' => 'Main Street',
            'qualification' => 'MBA',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Telecaller User',
            'email' => 'telecaller@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '9876543000',
            'alt_phone' => '9876543001',
            'address' => 'Second Street',
            'qualification' => 'BTech',
            'role' => 'telecaller',
        ]);
    }
}
