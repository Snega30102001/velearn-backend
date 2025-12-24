<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Courses;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Courses::create(['name' => 'Civil CAD']);
        Courses::create(['name' => 'Mech CAD']);
        Courses::create(['name' => 'Graphic Design']);
        Courses::create(['name' => 'VFX & Animation']);
        Courses::create(['name' => 'Gaming Design']);
    }
}
