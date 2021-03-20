<?php


namespace App\Services;


use App\Models\Questionnaire;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeService
{
    public function giveCountCompanyWithUserHasStatusHR(string $emailUser):int
    {
        $userFromDB = DB::table('users')
            ->where('email','=',$emailUser)
            ->join('hrworkers','users.id','=','hrworkers.user_id')
            ->get();

        return $userFromDB->count();
    }

    public function giveCompaniesWithUserHasStatusHR(int $idUser)
    {
        $companies = DB::table('companies')
            ->select('companies.name as name', 'companies.id as id')
            ->join('hrworkers','companies.id','=','hrworkers.company_id')
            ->where('hrworkers.user_id','=', $idUser)
            ->get();

        return $companies;
    }

    public function giveCountQuestionnairiesOfUserWithUpdateIsFresh(string $emailUser):int
    {
        $userFromDB = DB::table('users')->where('email','=',$emailUser)
            ->join('questionnaires','users.id','=','questionnaires.user_id')
            ->where('questionnaires.updated_at','>', Carbon::now()->subDays(30))
            ->get();

        return count($userFromDB);
    }

    public function storeNewQuestionnaire(int $idUser)
    {
        $questionnaire = new Questionnaire();
        $questionnaire->user_id = $idUser;
        $questionnaire->results = '{}';
        $questionnaire->save();
    }
}
