<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\CorrectUserRequest;
use App\Http\Requests\SearchUserRequest;
use App\Models\Company;
use App\Models\User;
use App\Services\AddUserService;
use App\Services\CorrectUserService;
use App\Services\SearchUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUsersController extends Controller
{
    public function users()
    {
        return view('admin.users',['users'=>User::orderBy('updated_at', 'asc')->paginate(config('app.pagination_users'))]);
    }

    public function searchUser(SearchUserRequest $request){

        $data = $request->only(['firstName','secondName','middleName','email','attribute']);
        $users = (new SearchUserService())->make($data);
        return view('admin.users', ['users'=>$users]);
    }

    public function addUserForm()
    {
        return view('admin.addUser',['companies'=>Company::where('is_delete', false)->get()]);
    }

    public function addUser(AddUserRequest $request){
        $data = $request->only(['email','secondName','firstName','middleName','department','company', 'hr', 'head', 'candidate','phone']);

        (new AddUserService())->make($data);

        return back()->with('success', 'Пользователь добавлен.');
    }

    public function deleteUser($id){
        $id = (int)$id;
        User::destroy($id);

        return back()->with('success', 'Пользователь удален.');
    }

    public function correctUser($id)
    {
        $id = (int)$id;
        return view('admin.correctUser',['user' => User::find($id)]);
    }

    public function correctUserAction(CorrectUserRequest $request)
    {
        $data = $request->only(['user_id','email','secondName','firstName','middleName']);
        (new CorrectUserService())->make($data);
        return back()->with('success', 'Данные скорректированы.');
    }

    public function user($id)
    {
        $id = (int)$id;
        $user = User::find($id);
        if ($user) {
            $worker = DB::table('workers')->select('company_id','companies.name as name','is_head', 'is_candidate','departments.name as name_department','departments.id as id_department')->where('workers.user_id',$id)->join('departments','workers.department_id', '=', 'departments.id')->join('companies', 'departments.company_id', '=', 'companies.id')->get();
            $HRworker = DB::table('hrworkers')->select('company_id','companies.name as name')->where('hrworkers.user_id',$id)->join('companies','hrworkers.company_id', '=', 'companies.id')->get();
        }else{
            $worker = 0;
            $HRworker = 0;

            return abort(404);
        }

        return view('admin.user',['user' => $user, 'worker'=>$worker, 'HRworker'=>$HRworker]);
    }

    public function makeAdmin($id)
    {
        $id = (int)$id;
        $user = User::find($id);
        $user->is_admin = true;
        $user->save();
        return back()->with('success', 'Пользователю присвоен статус Администратора.');
    }

    public function deleteStatusAdmin($id)
    {
        $id = (int)$id;
        $user = User::find($id);
        $user->is_admin = false;
        $user->save();
        return back()->with('success', 'Пользователь лишен статуса Администратора.');
    }
}
