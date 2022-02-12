<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Upcoming as Upcoming;
use Illuminate\Support\Str as Str;


class UpcomingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fakeData = \Faker\Factory::create(); // Will create an ugly data

        for($i = 0; $i < 5; $i++){
            Upcoming::create(
                array(
                    'completed'     => false,
                    'title'         => sprintf('Upcoming Task Title %s - %s', $i + 1, $fakeData->sentence(4, false)),
                    'approved'      => false,
                    'waiting'       => true,
                    'taskId'        => sprintf('TASK-ID-%1$03s-%2$s', $i + 1, Str::random(10)),
                )
            );
        }

    }
}
