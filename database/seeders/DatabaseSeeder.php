<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. 1st ID 1 User 
        User::factory()->create([
            'id' => 1,
            'name' => 'Sandun Admin',
            'email' => 'admin@example.com',
        ]);

        // 2.RequestSeeder call 
        $this->call([
            RequestSeeder::class,
        ]);
    }
}