<?php

use Illuminate\Database\Seeder;

class CreateGradeLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grade_levels')->insert([
            'name' => '1st',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '2nd',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '3rd',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '4th',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '5th',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '6th',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '7th',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '8th',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '9th/Fresfman',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '10th/Sophmore',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '11th/Junior',
        ]);
        DB::table('grade_levels')->insert([
            'name' => '12th/Senior',
        ]);
    }
}
