<?php


namespace App\Services;


use App\Models\Department;
use App\Models\HRworker;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{

    public function addUser($data):bool
    {
        $correctData = $this->giveCorrectDataForAddUser($data);

        DB::beginTransaction();

        $idNewUser = $this->addUserToDB($correctData);

        if ($correctData['department']){
            $this->addToDBInformationAboutDepartmentForCurrentUser($correctData, $idNewUser);
        }
        if ($correctData['hr']){
            $this->addToDBStatusHRForCurrentUser($correctData, $idNewUser);
        }
        DB::commit();

        return true;
    }

    private function giveCorrectDataForAddUser($data):array
    {
        $correctData = [];

        (isset($data['hr']))?($correctData['hr'] = $data['hr']):($correctData['hr'] = false);
        (isset($data['head']))?($correctData['head'] = $data['head']):($correctData['head'] = false);
        (isset($data['candidate']))?($correctData['candidate'] = $data['candidate']):($correctData['candidate'] = false);
        (isset($data['secondName']))?($correctData['secondName'] = $data['secondName']):($correctData['secondName'] = null);
        (isset($data['firstName']))?($correctData['firstName'] = $data['firstName']):($correctData['firstName'] = null);
        (isset($data['middleName']))?($correctData['middleName'] = $data['middleName']):($correctData['middleName'] = null);
        (isset($data['phone']))?($correctData['phone'] = $data['phone']):($correctData['phone'] = null);
        $correctData['email'] = $data['email'];
        $correctData['department'] = $data['department'];
        $correctData['company'] = $data['company'];
        $correctData['name'] = Str::slug($correctData['secondName']);
        if ($correctData['firstName']) ($correctData['name'] .=Str::slug(mb_substr($correctData['firstName'], 0, 1)));
        if ($correctData['middleName']) ($correctData['name'] .=Str::slug(mb_substr($correctData['middleName'], 0, 1)));

        return $correctData;
    }

    private function addUserToDB(array $correctData):int
    {
        $user = new User();
        $user->name = $correctData['name'];
        $user->email = $correctData['email'];
        $user->password = '11111111111';
        $user->is_admin = false;
        $user->firstName = $correctData['firstName'];
        $user->secondName = $correctData['secondName'];
        $user->middleName = $correctData['middleName'];
        $user->save();

        return (int)($user->id);
    }

    private function addToDBInformationAboutDepartmentForCurrentUser(array $correctData, int $idUser):void
    {
        $worker = new Worker();
        $worker->user_id = $idUser;
        $worker->department_id = $correctData['department'];
        $worker->is_head = $correctData['head'];
        $worker->is_candidate = $correctData['candidate'];
        $worker->save();
    }

    private function addToDBStatusHRForCurrentUser(array $correctData, int $idUser):void
    {
        $HRworker = new HRworker();
        $HRworker->user_id = $idUser;
        $HRworker->company_id = $correctData['company'];
        $HRworker->phone = $correctData['phone'];
        $HRworker->save();
    }

    public function searchUser($data)
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
        if ($attribute) $arrayRequest[] = ['is_admin','=','1'];

        return DB::table('users')
            ->orderBy('updated_at')
            ->where($arrayRequest)
            ->select('id','firstName', 'secondName','middleName', 'email','is_admin')
            ->paginate(config('app.pagination_users'))
            ->appends('firstName',$firstName)
            ->appends('secondName',$secondName)
            ->appends('middleName',$middleName)
            ->appends('email',$email)
            ->appends('attribute',$attribute);
    }

    public function correctUser($data):bool
    {
        $email = $data['email'];
        $user_id = (int)$data['user_id'];
        $secondName = $data['secondName'];
        $firstName = $data['firstName'];
        $middleName = $data['middleName'];

        $user = User::find($user_id);
        $user->email = $email;
        $user->secondName = $secondName;
        $user->firstName = $firstName;
        $user->middleName = $middleName;
        $user->save();

        return true;
    }

    public function giveInformationAboutUser (int $idUser):array
    {
        $worker = DB::table('workers')
            ->select('company_id','companies.name as name','is_head', 'is_candidate','departments.name as name_department','departments.id as id_department')
            ->where('workers.user_id',$idUser)
            ->join('departments','workers.department_id', '=', 'departments.id')
            ->join('companies', 'departments.company_id', '=', 'companies.id')
            ->get();
        $HRworker = DB::table('hrworkers')
            ->select('company_id','companies.name as name')
            ->where('hrworkers.user_id',$idUser)
            ->join('companies','hrworkers.company_id', '=', 'companies.id')
            ->get();

        return array($worker, $HRworker);
    }

    public function giveStatusAdminToUser(int $idUser):void
    {
        $user = User::find($idUser);
        $user->is_admin = true;
        $user->save();
    }

    public function deleteStatusAdminToUser(int $idUser):void
    {
        $user = User::find($idUser);
        $user->is_admin = false;
        $user->save();
    }

    public function findUserByEmail($email):array
    {
        $user = User::where('email',$email)->first();

        return array($user);
    }

    public function giveIdCompanyByCurrentlyHR()
    {
        return session('idCompanyForHR');
    }

}
