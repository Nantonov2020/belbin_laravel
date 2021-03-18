<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class SearchUserService
{
    public function make($data){

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
}
