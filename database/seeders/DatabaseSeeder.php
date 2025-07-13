<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // You can remove this line if you’re using UserSeeder
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // ✅ Correct placement of the seeder calls
        $this->call([
            UserSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
