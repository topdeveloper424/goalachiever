<?php

use Illuminate\Database\Seeder;

class CreateStateCityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        DB::unprepared(file_get_contents(public_path('query/states.sql')));
        $this->command->info('States table seeded!');
        DB::unprepared(file_get_contents(public_path('query/cities.sql')));
        $this->command->info('Cities table seeded!');

    }
}
