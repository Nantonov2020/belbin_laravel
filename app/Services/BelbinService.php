<?php


namespace App\Services;


use App\Models\Department;
use Illuminate\Support\Facades\DB;

class BelbinService
{
    public function giveInformationAboutQuestionnariesOfUsersOfDepartmentWithInfoAboutDepartment(int $idDepartment):array
    {
        $department = Department::find($idDepartment);
        $questionaries = DB::table('questionnaires')
                        ->join('users','questionnaires.user_id','=','users.id')
                        ->join('workers', 'users.id', '=','workers.user_id')
                        ->where('workers.department_id', $idDepartment)
                        ->get();

        return array($department, $questionaries);
    }
}
