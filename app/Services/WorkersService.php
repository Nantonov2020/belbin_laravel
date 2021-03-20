<?php


namespace App\Services;


use App\Models\Worker;

class WorkersService
{
    public function makeCorrectDataForStatusWorkerForUser($data):array
    {
        $correctData = [];
        (isset($data['head']))?($correctData['head'] = true):($correctData['head'] = false);
        (isset($data['candidate']))?($correctData['candidate'] = true):($correctData['candidate'] = false);
        $correctData['department'] = (int)$data['department'];
        $correctData['user_id'] = (int)$data['user_id'];

        return $correctData;
    }

    public function makeStatusWorkerForUser(array $correctData):void
    {
        $worker = new Worker();
        $worker->user_id = $correctData['user_id'];
        $worker->department_id = $correctData['department'];
        $worker->is_head = $correctData['head'];
        $worker->is_candidate = $correctData['candidate'];
        $worker->save();
    }

}
