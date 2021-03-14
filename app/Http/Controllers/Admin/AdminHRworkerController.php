<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\HRworker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHRworkerController extends Controller
{
    public function giveStatusHR($id){
        $id = (int)$id;
        return view('admin.giveStatusHR',['user' => User::find($id), 'companies' => Company::where('is_delete', false)->get()]);
    }

    public function giveStatusHRAction(Request $request)
    {
        $data = $request->only(['user_id','company']);

        $user_id = (int)$data['user_id'];
        $company_id = (int)$data['company'];

        if ($company_id) {
            $HRworker = new HRworker();
            $HRworker->user_id = $user_id;
            $HRworker->company_id = $company_id;
            $HRworker->save();

            return back()->with('success', 'Пользователю присвоен статус HR.');
        }
        return back()->with('success', 'Не указана организация.');
    }

    public function deleteStatusHRworker($user_id,$company_id)
    {
        $user_id = (int)$user_id;
        $company_id = (int)$company_id;

        HRworker::where('user_id',$user_id)->where('company_id',$company_id)->first()->delete();

        return back()->with('success', 'Пользователю удалён статус HR.');
    }

    public function HRworkers()
    {
        $HRworkers = DB::table('hrworkers')->select('user_id','company_id','phone','email','companies.name as company_name','firstName','secondName','middleName')->join('users','hrworkers.user_id', '=', 'users.id')->join('companies','hrworkers.company_id', '=', 'companies.id')->paginate(config('app.pagination_users'));

        return view('admin.HRworkers',['HRworkers' => $HRworkers]);

    }

}
