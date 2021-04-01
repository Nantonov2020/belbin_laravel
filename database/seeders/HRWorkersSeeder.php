<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HRWorkersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hrworkers')->insert($this->getData());
    }

    private function getData():array
    {
        $users = DB::table('users')->select('id')->get();
        $companies = DB::table('companies')->select('id')->get();

        $data = [];
        for ($i = 0; $i < 200; $i++){
            $user_id =  ($users[Rand(0,count($users)-1)])->id;
            $company_id =  ($companies[Rand(0,count($companies)-1)])->id;
            $data[] =[
                'user_id' => $user_id,
                'company_id' => $company_id
            ];
        }
        return $data;
    }
}
