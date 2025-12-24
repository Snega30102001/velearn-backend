<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeadTimeLine;
use Carbon\Carbon;

class LeadTimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadTimeLine::create([
            'lead_id' => 1,
            'event' => 'Lead Created',
            'remarks' => 'First contact made via phone.',
            'event_time' => Carbon::now(),
            'added_by' => 1,
        ]);

        LeadTimeLine::create([
            'lead_id' => 1,
            'event' => 'Follow-up Call',
            'remarks' => 'Lead asked for details.',
            'event_time' => Carbon::now()->addDay(),
            'added_by' => 2,
        ]);
    }
}
