<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionnairesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questionnaires')->insert($this->getData());
    }

    private function getData():array
    {
        $users = DB::table('users')->select('id')->get();

        $data = [];
        for ($i = 0; $i < 10000; $i++){
            $user_id =  ($users[Rand(0,count($users)-1)])->id;
            $status =  1;
            $results = $this->giveResultFormatJSON();
            $data[] =[
                'user_id' => $user_id,
                'status' => $status,
                'results' => $results,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        return $data;
    }

    private function giveResultFormatJSON():string
    {
        $result = [];
        for ($i = 0; $i < 7; $i++){
            $result[$i] = $this->giveRandomResultsForOneQuestions();
        }

        return json_encode($result, JSON_FORCE_OBJECT);
    }

    private function giveRandomResultsForOneQuestions():array
    {
        $result = [0,0,0,0,0,0,0,0];

        for ($i = 0; $i < 10; $i++){
            $key = rand(0,7);
            $result[$key]++;
        }

        return $result;
    }
}
