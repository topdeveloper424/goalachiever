<?php

use Illuminate\Database\Seeder;

class CreateUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('users')->insert([
            'user_id'=>'GA000001',
            'name' => 'Lee Bin',
            'email' => 'mingming424224@gmail.com',
            'role' => 0,
            'password' => bcrypt('mingming'),
            'phone' => $faker->phoneNumber(),
            'city' => 'Donald',
            'state' => 'OR',
            'educator' => $faker->boolean(),
            'veteran' => $faker->boolean(),
            'app_purchase' => $faker->boolean(),
            'app_commission' => $faker->boolean(),
            'representative' => $faker->boolean(),
            'donation' => 0,
            'amount' => 100,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'created_by' => '1',
        ]);
        DB::table('users')->insert([
            'user_id'=>'GA000002',
            'name' => $faker->name(),
            'email' => $faker->email(),
            'role' => 1,
            'password' => bcrypt('mingming'),
            'phone' => $faker->phoneNumber(),
            'city' => 'Acushnet',
            'state' => 'MA',
            'educator' => $faker->boolean(),
            'veteran' => $faker->boolean(),
            'app_purchase' => $faker->boolean(),
            'app_commission' => $faker->boolean(),
            'representative' => $faker->boolean(),
            'donation' => 0,
            'amount' => 100,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'created_by' => '1',
        ]);
        DB::table('users')->insert([
            'user_id'=>'GA000003',
            'name' => $faker->name(),
            'email' => $faker->email(),
            'role' => 2,
            'password' => bcrypt('mingming'),
            'phone' => $faker->phoneNumber(),
            'city' => 'Genoa',
            'state' => 'CO',
            'address1' => $faker->address(),
            'educator' => $faker->boolean(),
            'veteran' => $faker->boolean(),
            'app_purchase' => $faker->boolean(),
            'app_commission' => $faker->boolean(),
            'representative' => $faker->boolean(),
            'donation' => 0,
            'amount' => 100,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'created_by' => '1',
        ]);

        // goal achiever
        DB::table('users')->insert([
            'user_id'=>'GA000004',
            'name' => $faker->name(),
            'email' => $faker->email(),
            'role' => 3,
            'password' => bcrypt('mingming'),
            'phone' => $faker->phoneNumber(),
            'city' => 'Grove',
            'state' => 'OK',
            'address1' => $faker->address(),
            'address2' => $faker->address(),
            'website' => $faker->domainName(),
            'educator' => $faker->boolean(),
            'veteran' => $faker->boolean(),
            'app_purchase' => $faker->boolean(),
            'app_commission' => $faker->boolean(),
            'representative' => $faker->boolean(),
            'donation' => 0,
            'amount' => 100,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'created_by' => '1',
        ]);

        //school participant
        DB::table('users')->insert([
            'user_id'=>'GA000005',
            'name' => $faker->name(),
            'email' => $faker->email(),
            'role' => 4,
            'password' => bcrypt('mingming'),
            'phone' => $faker->phoneNumber(),
            'city' => 'Higden',
            'state' => 'AR',
            'name2' => $faker->company(),
            'address1' => $faker->address(),
            'website' => $faker->domainName(),
            'grade_type' => 1,
            'educator' => $faker->boolean(),
            'veteran' => $faker->boolean(),
            'app_purchase' => $faker->boolean(),
            'app_commission' => $faker->boolean(),
            'representative' => $faker->boolean(),
            'donation' => 0,
            'amount' => 100,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'created_by' => '1',
        ]);

        //Sponsors
        DB::table('users')->insert([
            'user_id'=>'GA000005',
            'name' => $faker->name(),
            'email' => $faker->email(),
            'role' => 5,
            'password' => bcrypt('mingming'),
            'phone' => $faker->phoneNumber(),
            'city' => 'Island',
            'state' => 'KY',
            'name2' => $faker->company(),
            'address1' => $faker->address(),
            'website' => $faker->domainName(),
            'grade_type' => 1,
            'educator' => $faker->boolean(),
            'veteran' => $faker->boolean(),
            'app_purchase' => $faker->boolean(),
            'app_commission' => $faker->boolean(),
            'representative' => $faker->boolean(),
            'donation' => 0,
            'amount' => 100,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'created_by' => '1',
        ]);
    }
}
