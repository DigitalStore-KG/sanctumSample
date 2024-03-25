<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker= Faker::create();
        for($i=1; $i<=50; $i++){
            $user= new User;
            $user->name     =   $faker->name;
            $user->email    =   $faker->email;
            $user->city     =   $faker->city;
            $user->country  =   $faker->country;
            $user->password =   $faker->password;
            $user->save();
        }
    }
}
