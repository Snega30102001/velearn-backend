<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lead;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lead::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '9000000001',
            'source' => 'Instagram',
            'course_id' => 1,
            'course_type_id' => 1,
            'assigned_to' => 2,
            'status' => 'hot',
            'created_by' => 1,
        ]);

        Lead::create([
            'name' => 'Priya',
            'email' => 'priya@example.com',
            'phone' => '9000000002',
            'source' => 'Facebook',
            'course_id' => 2,
            'course_type_id' => 4,
            'assigned_to' => 1,
            'status' => 'warm',
            'created_by' => 1,
        ]);
    }
}
