<?php

use Illuminate\Database\Seeder;

class CreateTypeBusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_businesses')->insert([
            'name' => 'Profesional Services',
        ]);
        DB::table('type_businesses')->insert([
            'name' => 'Retail',
        ]);
        DB::table('type_businesses')->insert([
            'name' => 'Restaurant',
        ]);
        DB::table('type_businesses')->insert([
            'name' => 'Automative',
        ]);
        DB::table('type_businesses')->insert([
            'name' => 'Health & Fitness',
        ]);
        DB::table('type_businesses')->insert([
            'name' => 'Non-Profit',
        ]);
    }
}
