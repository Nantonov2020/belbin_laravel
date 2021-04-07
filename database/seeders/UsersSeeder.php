<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert($this->getData());
    }

    private function getData():array
    {
        $faker = Factory::create('ru_RU');

        $data = [];
        for ($i = 0; $i < 10000; $i++){
            $firstName = $faker->firstNameMale;
            $secondName = $faker->lastName;
            $middleName = $faker->lastName;
            ($i < 100)?$password = Hash::make('12345678'):$password = '11111111';
            $name = Str::slug($firstName);
            $email = ($faker->word).($faker->numberBetween(5,1000000)).($faker->numberBetween(5,1000000)).'@mail.ru';
            $data[] =[
                'firstName' => $firstName,
                'secondName' => $secondName,
                'middleName' => $middleName,
                'name' => $name,
                'password' => $password,
                'email'=>$email
            ];
        }
        return $data;
    }
}

