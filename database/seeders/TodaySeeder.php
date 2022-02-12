<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Today as Today;
use Illuminate\Support\Str as Str;


class TodaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $fakeData = \Faker\Factory::create(); // Will create an ugly data    
        
        for($i = 0; $i < 5; $i++){
            Today::create(
                array(
                    'completed'     => false,
                    'title'         => sprintf('Today Task Title %s - %s', $i + 1, $fakeData->sentence(4, false)),
                    'approved'      => false,                   
                    'taskId'        => sprintf('TASK-ID-%1$03s-%2$s', $i + 1, Str::random(10)),
                )
            );
        }

    }
}
