<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert($this->getData());
    }

    private function getData():array
    {
        $faker = Factory::create('ru_Ru');

        $companies = DB::table('companies')->select('id')->get();

        $data = [];
        for ($i = 0; $i < 1000; $i++){
            $company_id =  ($companies[Rand(0,count($companies)-1)])->id;
            $name = $faker->text($maxNbChars = 80);

            $data[] =[
                'name' => $name,
                'company_id' => $company_id
            ];
        }
        return $data;
    }
}
