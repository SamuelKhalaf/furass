<?php

namespace Database\Seeders;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $i) {
            $event = Event::create([
                'event_name'    => 'Event ' . $i,
                'company_name'  => 'Company ' . $i,
                'location'      => 'City ' . $i,
                'event_time'    => Carbon::now()->addDays($i),
                'content_type'  => ['pdf', 'video', 'text'][array_rand(['pdf', 'video', 'text'])],
                'content_path'  => 'path/to/sample-' . $i . '.pdf',
                'event_type'    => ['trip', 'workshop'][rand(0, 1)],
            ]);
        }
    }
}
