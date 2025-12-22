<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request as PickupRequest;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        // 1st request 
        PickupRequest::create([
            'user_id' => 1, 
            'address' => 'Colombo Fort Station',
            'latitude' => 6.9344,
            'longitude' => 79.8428,
            'status' => 'pending'
        ]);

        // 2nd request 
        PickupRequest::create([
            'user_id' => 1,
            'address' => 'Borella Junction',
            'latitude' => 6.9142,
            'longitude' => 79.8789,
            'status' => 'pending'
        ]);

        // 3rd request 
        PickupRequest::create([
            'user_id' => 1,
            'address' => 'Bambalapitiya',
            'latitude' => 6.8972,
            'longitude' => 79.8552,
            'status' => 'pending'
        ]);
    }
}