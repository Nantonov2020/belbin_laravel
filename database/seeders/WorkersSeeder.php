<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workers')->insert($this->getData());
    }

    private function getData():array
    {
        $departments = DB::table('departments')->select('id')->get();
        $users = DB::table('users')->select('id')->get();

        $data = [];
        for ($i = 0; $i < 5000; $i++){
            $user_id =  ($users[Rand(0,count($users)-1)])->id;
            $department_id =  ($departments[Rand(0,count($departments)-1)])->id;
            (rand(0,100) < 10)?($is_head = true):($is_head = false);
            (rand(0,100) < 30)?($is_candidate = true):($is_candidate = false);

            $data[] =[
                'user_id' => $user_id,
                'department_id' => $department_id,
                'is_head' => $is_head,
                'is_candidate' => $is_candidate
            ];
        }
        return $data;
    }
}
