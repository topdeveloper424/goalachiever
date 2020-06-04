<?php

use Illuminate\Database\Seeder;

class CreateGoalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('goal_types')->insert([
            'goal' => 0,
            'name' => 'House Down Payment',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 0,
            'name' => 'Pay Off Debt',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 1,
            'name' => 'College',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 1,
            'name' => 'Trade School',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 2,
            'name' => 'Doctor',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 2,
            'name' => 'Lawyer',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 3,
            'name' => 'Stop Smoking',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 3,
            'name' => 'Stop Drinking',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 4,
            'name' => 'Lose Weight',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 5,
            'name' => 'Mexico',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 5,
            'name' => 'Jamaica',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 5,
            'name' => 'Spain',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 5,
            'name' => 'Europe',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 6,
            'name' => 'Insurance Coverage',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 7,
            'name' => 'Retirement',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 8,
            'name' => 'Real Estate Purchase Closing Cost',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 9,
            'name' => 'Real Estate Listing Closing Cost',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 10,
            'name' => 'Reverse Mortgage',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 10,
            'name' => 'Refinance Loan',
        ]);
        DB::table('goal_types')->insert([
            'goal' => 10,
            'name' => 'VA Loan',
        ]);
    }
}
