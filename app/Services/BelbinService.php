<?php


namespace App\Services;


use App\Models\CellForTableResultDepartmentBelbinTest;
use App\Models\Department;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BelbinService
{
    public function giveInformationAboutQuestionnariesOfUsersOfDepartmentWithInfoAboutDepartment(int $idDepartment):array
    {
        $department = Department::select('id','name')->find($idDepartment);

        $numbersQuestionariesWithoutRepeat = $this->giveNumbersQuestionariesWithoutRepeat($idDepartment);

        $questionaries = DB::table('questionnaires')
                        ->select('users.id as idUser', 'results', 'questionnaires.id', 'firstName', 'secondName', 'middleName', 'is_admin', 'is_head', 'is_candidate')
                        ->join('users','questionnaires.user_id','=','users.id')
                        ->join('workers', 'users.id', '=','workers.user_id')
                        ->orderBy('workers.is_head','desc')
                        ->orderBy('workers.is_candidate','asc')
                        ->whereIn('questionnaires.id',$numbersQuestionariesWithoutRepeat)
                        ->where('workers.department_id', $idDepartment)
                        ->where('questionnaires.status', true)
                        ->get();

        foreach ($questionaries as $item){
            $resultForTable = $this->convertAnswersToResult(json_decode($item->results, true));
            $item->resultForTable = $resultForTable;
        }
        $averageResults = $this->getAverageResultsColumns($questionaries);

        return array($department, $questionaries, $averageResults);
    }

    private function giveNumbersQuestionariesWithoutRepeat(int $idDepartment):array
    {
        $questionaries = DB::table('questionnaires')
            ->select(DB::raw('MAX(questionnaires.id) as max'))
            ->join('users','questionnaires.user_id','=','users.id')
            ->join('workers', 'users.id', '=','workers.user_id')
            ->where('workers.department_id', $idDepartment)
            ->where('questionnaires.status', true)
            ->groupBy('questionnaires.user_id')
            ->get();

        $numbersQuestionariesWithoutRepeat = [];

        foreach($questionaries as $item)
        {
            $numbersQuestionariesWithoutRepeat[] = $item->max;
        }

        return $numbersQuestionariesWithoutRepeat;
    }

    private function convertAnswersToResult(array $results):array
    {
        $resultForTable = [];
        $value = $results[0][6] + $results[1][0] + $results[2][7] + $results[3][3] + $results[4][1] + $results[5][5] + $results[6][4];
        $resultForTable[0] = new CellForTableResultDepartmentBelbinTest($value, 0);

        $value = $results[0][3] + $results[1][1] + $results[2][0] + $results[3][7] + $results[4][5] + $results[5][2] + $results[6][6];
        $resultForTable[1] = new CellForTableResultDepartmentBelbinTest($value, 1);

        $value = $results[0][5] + $results[1][4] + $results[2][2] + $results[3][1] + $results[4][3] + $results[5][6] + $results[6][0];
        $resultForTable[2] = new CellForTableResultDepartmentBelbinTest($value, 2);

        $value = $results[0][2] + $results[1][6] + $results[2][3] + $results[3][4] + $results[4][7] + $results[5][0] + $results[6][5];
        $resultForTable[3] = new CellForTableResultDepartmentBelbinTest($value, 3);

        $value = $results[0][0] + $results[1][2] + $results[2][5] + $results[3][6] + $results[4][4] + $results[5][7] + $results[6][3];
        $resultForTable[4] = new CellForTableResultDepartmentBelbinTest($value, 4);

        $value = $results[0][7] + $results[1][3] + $results[2][6] + $results[3][2] + $results[4][0] + $results[5][4] + $results[6][1];
        $resultForTable[5] = new CellForTableResultDepartmentBelbinTest($value, 5);

        $value = $results[0][1] + $results[1][5] + $results[2][4] + $results[3][0] + $results[4][2] + $results[5][1] + $results[6][7];
        $resultForTable[6] = new CellForTableResultDepartmentBelbinTest($value, 6);

        $value = $results[0][4] + $results[1][7] + $results[2][1] + $results[3][5] + $results[4][6] + $results[5][3] + $results[6][2];
        $resultForTable[7] = new CellForTableResultDepartmentBelbinTest($value, 7);

        return $resultForTable;
    }

    private function getAverageResultsColumns($questionaries):array
    {
        $averageResults = [0,0,0,0,0,0,0,0];
        if (count($questionaries) == 0) {
            return $averageResults;
        }
        foreach ($questionaries as $item){
            foreach ($item->resultForTable as $key=>$value){
                $averageResults[$key] +=  $value->getValue();
            }
        }
        foreach ($averageResults as $key=>$item)
        {
            $averageResults[$key] = round($item/(count($questionaries)),2);
        }
        return $averageResults;
    }

    public function getJSONFromQuestionnairesForJS($questionaries)
    {
        $result = [];

        foreach($questionaries as $item)
        {
            $localArray = [];
            $name = $item->secondName;
            foreach ($item->resultForTable as $objCell)
            {
                $localArray[] = $objCell->getValue();
            }

            $result[] = ['name' => $name, 'result' => $localArray];
        }

        $resultStr = json_encode($result);
        return $resultStr;
    }

    public function makeDataForShowResultsBelbinForUser(int $idWorker):array
    {
        $user = User::find($idWorker);
        $questionaries = Questionnaire::where('user_id', $idWorker)->get();
        foreach ($questionaries as $item){
            $resultForTable = $this->convertAnswersToResult(json_decode($item->results, true));
            $item->resultForTable = $resultForTable;
        }
        return array($user, $questionaries);
    }
}
