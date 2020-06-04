<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateUserTable::class);
        $this->call(CreateContactTableSeeder::class);
        $this->call(CreateGoalTypeSeeder::class);
        $this->call(CreateGradeLevelTableSeeder::class);
        $this->call(CreateTypeBusinessTableSeeder::class);
        $this->call(CreateStateCityTableSeeder::class);
    }
}
