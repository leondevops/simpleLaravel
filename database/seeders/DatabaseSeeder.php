<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TodaySeeder;
use Database\Seeders\UpcomingSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(
            array(
                TodaySeeder::class,
                UpcomingSeeder::class,    
            )                  
        );

    }
}
