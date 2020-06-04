<?php

use Illuminate\Database\Seeder;

class CreateContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i ++){
            DB::table('contacts')->insert([
                'name' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'website' => $faker->domainName(),
                'email' => $faker->email(),
                'contact_name' => $faker->name(),
                'address' => $faker->address(),
                'type' => 0,
            ]);

        }

        for ($i = 0; $i < 10; $i ++){
            DB::table('contacts')->insert([
                'name' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'website' => $faker->domainName(),
                'email' => $faker->email(),
                'contact_name' => $faker->name(),
                'address' => $faker->address(),
                'type' => 1,
            ]);

        }

        for ($i = 0; $i < 10; $i ++){
            DB::table('contacts')->insert([
                'name' => $faker->name(),
                'phone' => $faker->phoneNumber(),
                'website' => $faker->domainName(),
                'email' => $faker->email(),
                'contact_name' => $faker->name(),
                'address' => $faker->address(),
                'type' => 2,
            ]);

        }

    }
}
