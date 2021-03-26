<?php


namespace App\Services;


use App\Models\Department;
use Illuminate\Support\Facades\DB;

class BelbinService
{
    public function giveInformationAboutQuestionnariesOfUsersOfDepartmentWithInfoAboutDepartment(int $idDepartment):array
    {
        $department = Department::select('id','name')->find($idDepartment);
        $questionaries = DB::table('questionnaires')
                        ->join('users','questionnaires.user_id','=','users.id')
                        ->join('workers', 'users.id', '=','workers.user_id')
                        ->where('workers.department_id', $idDepartment)
                        ->get();
        foreach ($questionaries as $item){
            $resultForTable = $this->convertAnswersToResult(json_decode($item->results, true));
            $item->resultForTable = $resultForTable;
        }
        return array($department, $questionaries);
    }

    private function convertAnswersToResult(array $results):array
    {
        $resultForTable = [];
        $resultForTable[0] = $results[0][6] + $results[1][0] + $results[2][7] + $results[3][3] + $results[4][1] + $results[5][5] + $results[6][4];
        $resultForTable[1] = $results[0][3] + $results[1][1] + $results[2][0] + $results[3][7] + $results[4][5] + $results[5][2] + $results[6][6];
        $resultForTable[2] = $results[0][5] + $results[1][4] + $results[2][2] + $results[3][1] + $results[4][3] + $results[5][6] + $results[6][0];
        $resultForTable[3] = $results[0][2] + $results[1][6] + $results[2][3] + $results[3][4] + $results[4][7] + $results[5][0] + $results[6][5];
        $resultForTable[4] = $results[0][0] + $results[1][2] + $results[2][5] + $results[3][6] + $results[4][4] + $results[5][7] + $results[6][3];
        $resultForTable[5] = $results[0][7] + $results[1][3] + $results[2][6] + $results[3][2] + $results[4][0] + $results[5][4] + $results[6][1];
        $resultForTable[6] = $results[0][1] + $results[1][5] + $results[2][4] + $results[3][0] + $results[4][2] + $results[5][1] + $results[6][7];
        $resultForTable[7] = $results[0][4] + $results[1][7] + $results[2][1] + $results[3][5] + $results[4][6] + $results[5][3] + $results[6][2];

        return $resultForTable;
    }

}
