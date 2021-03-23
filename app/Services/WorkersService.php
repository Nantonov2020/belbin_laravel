<?php


namespace App\Services;


use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;

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

    public function giveAllWorkersOfCompanyWithPaginate(int $idCompany)
    {
        $workers = DB::table('workers')
                ->select('users.id as id', 'firstName', 'secondName', 'middleName', 'email', 'is_head', 'is_candidate')
                ->join('users','workers.user_id','=','users.id')
                ->join('departments','workers.department_id','=','departments.id')
                ->join('companies','departments.company_id','=','companies.id')
                ->where('companies.id','=',$idCompany)
                ->paginate(config('app.pagination_users'));

        return $workers;
    }

    public function searchWorkersOfCompanyWithPaginate($data, int $idCompany)
    {
        (isset($data['firstName']))?($firstName = $data['firstName']):($firstName = null);
        (isset($data['secondName']))?($secondName = $data['secondName']):($secondName = null);
        (isset($data['middleName']))?($middleName = $data['middleName']):($middleName = null);
        (isset($data['email']))?($email = $data['email']):($email = null);
        (isset($data['attribute']))?($attribute = $data['attribute']):($attribute = null);

        $arrayRequest = [];

        if ($firstName) $arrayRequest[] = ['firstName','like',"%$firstName%"];
        if ($secondName) $arrayRequest[] = ['secondName','like',"%$secondName%"];
        if ($middleName) $arrayRequest[] = ['middleName','like',"%$middleName%"];
        if ($email) $arrayRequest[] = ['email','like',"%$email%"];
        if ($attribute == 1) $arrayRequest[] = ['workers.is_head','=',true];
        if ($attribute == 2) $arrayRequest[] = ['workers.is_candidate','=',true];

        $workers = DB::table('workers')
            ->select('users.id as id', 'firstName', 'secondName', 'middleName', 'email', 'is_head', 'is_candidate', 'companies.id as id_company')
            ->where($arrayRequest)
            ->join('users','workers.user_id','=','users.id')
            ->join('departments','workers.department_id','=','departments.id')
            ->join('companies','departments.company_id','=','companies.id')
            ->where('companies.id','=',$idCompany)
            ->paginate(config('app.pagination_users'));

        return $workers;
    }

    public function giveInformationAboutOneWorker(int $idWorker):array
    {
        $user = User::find($idWorker);
        $worker = DB::table('workers')
            ->select('company_id','companies.name as name','is_head', 'is_candidate','departments.name as name_department','departments.id as id_department')
            ->where('workers.user_id',$idWorker)
            ->join('departments','workers.department_id', '=', 'departments.id')
            ->join('companies', 'departments.company_id', '=', 'companies.id')
            ->get();
        $HRworker = DB::table('hrworkers')
            ->select('company_id','companies.name as name')
            ->where('hrworkers.user_id',$idWorker)
            ->join('companies','hrworkers.company_id', '=', 'companies.id')
            ->get();

        return array($user, $worker, $HRworker);
    }
}
