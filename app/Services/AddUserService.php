<?php


namespace App\Services;


use App\Models\HRworker;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddUserService
{
    public function make($data)
    {
        (isset($data['hr']))?($hr = $data['hr']):($hr = false);
        (isset($data['head']))?($head = $data['head']):($head = false);
        (isset($data['candidate']))?($candidate = $data['candidate']):($candidate = false);
        (isset($data['secondName']))?($secondName = $data['secondName']):($secondName = null);
        (isset($data['firstName']))?($firstName = $data['firstName']):($firstName = null);
        (isset($data['middleName']))?($middleName = $data['middleName']):($middleName = null);
        (isset($data['phone']))?($phone = $data['phone']):($phone = null);
        $email = $data['email'];
        $department = $data['department'];
        $company = $data['company'];
        $name = Str::slug($secondName);
        if ($firstName) ($name .=Str::slug(mb_substr($firstName, 0, 1)));
        if ($middleName) ($name .=Str::slug(mb_substr($middleName, 0, 1)));

        DB::beginTransaction();

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = '11111111111';
        $user->is_admin = false;
        $user->firstName = $firstName;
        $user->secondName = $secondName;
        $user->middleName = $middleName;
        $user->save();

        $user = User::where('email',$email)->first();
        $id = $user->id;

        if ($department){
            $worker = new Worker();
            $worker->user_id = $id;
            $worker->department_id = $department;
            $worker->is_head = $head;
            $worker->is_candidate = $candidate;
            $worker->save();
        }

        if ($hr){
            $HRworker = new HRworker();
            $HRworker->user_id = $id;
            $HRworker->company_id = $company;
            $HRworker->phone = $phone;
            $HRworker->save();
        }

        DB::commit();

        return true;
    }
}
