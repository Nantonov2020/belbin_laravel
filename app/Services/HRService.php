<?php


namespace App\Services;


use App\Models\HRworker;
use Illuminate\Support\Facades\DB;

class HRService
{
    public function giveStatusHRforUser(int $idUser, int $idCompany):void
    {
        $HRworker = new HRworker();
        $HRworker->user_id = $idUser;
        $HRworker->company_id = $idCompany;
        $HRworker->save();
    }

    public function deleteStatusHRworker(int $idUser, int $idCompany):void
    {
        HRworker::where('user_id',$idUser)->where('company_id',$idCompany)->first()->delete();
    }

    public function giveInformationAboutAllHRWorkers()
    {
        $HRworkers = DB::table('hrworkers')
            ->select('user_id','company_id','phone','email','companies.name as company_name','firstName','secondName','middleName')
            ->join('users','hrworkers.user_id', '=', 'users.id')
            ->join('companies','hrworkers.company_id', '=', 'companies.id')
            ->paginate(config('app.pagination_users'));

        return $HRworkers;
    }

    public function giveInformationAboutAllHRByIdCompany(int $idCompany)
    {
        $HRWorkers = DB::table('hrworkers')
                    ->where('company_id', $idCompany)
                    ->join('users', 'hrworkers.user_id','=','users.id')
                    ->cursor();

        return $HRWorkers;
    }

}
