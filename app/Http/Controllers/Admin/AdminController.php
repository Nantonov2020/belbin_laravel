<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\CorrectUserRequest;
use App\Http\Requests\DeleteCompanyRequest;
use App\Http\Requests\MakeWorkerRequest;
use App\Http\Requests\SearchUserRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\HRworker;
use App\Models\User;
use App\Models\Worker;
use App\Services\AddUserService;
use App\Services\CorrectUserService;
use App\Services\SearchUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class AdminController extends Controller
{

/*
    public function departments()
    {

       $departments = DB::table('companies')->orderBy('companies.id')->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')->join('departments','companies.id', '=', 'departments.company_id')->paginate(config('app.pagination_departments'));

        return view('admin.departments',['departments'=>$departments]);
    }

    public function findDepartment(Request $request)
    {
        $data = $request->only(['name']);
        $name = $data['name'];
        $departments = DB::table('companies')->orderBy('companies.id')->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')->where('departments.name', 'like', "%$name%")->join('departments','companies.id', '=', 'departments.company_id')->paginate(config('app.pagination_departments'))->appends('name',$name);
        return view('admin.departments',['departments'=>$departments]);
    }

    public function deleteDepartment(DeleteCompanyRequest $request)
    {
        $data = $request->only(['id','type']);
        $id = $data['id'];
        $type = $data['type'];
        $company = Department::find($id);
        $company->is_delete = (bool)$type;
        $company->save();
        return back();
    }

    public function addDepartment()
    {
        return view('admin.addDepartment',['companies'=>Company::where('is_delete', false)->get()]);
    }

    public function renameDepartment($id)
    {
        return view('admin.renameDepartment',['department'=>Department::find($id)]);
    }

    public function users()
    {
        return view('admin.users',['users'=>User::orderBy('updated_at', 'asc')->paginate(config('app.pagination_users'))]);
    }

    public function searchUser(SearchUserRequest $request){

        $data = $request->only(['firstName','secondName','middleName','email','attribute']);
        $users = (new SearchUserService())->make($data);
        return view('admin.users', ['users'=>$users]);
    }

    public function HRworkers()
    {
        $HRworkers = DB::table('hrworkers')->select('user_id','company_id','phone','email','companies.name as company_name','firstName','secondName','middleName')->join('users','hrworkers.user_id', '=', 'users.id')->join('companies','hrworkers.company_id', '=', 'companies.id')->paginate(config('app.pagination_users'));

        return view('admin.HRworkers',['HRworkers' => $HRworkers]);

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

    public function giveSetDepartments(Request $request) //Ajax
    {
        $data = $request->only(['id']);
        $id = (int)$data['id'];
        $departments = Department::where('company_id',$id)->get();
        $results = [];

        foreach ($departments as $department){
            $results[$department->id] = $department->name;
        }

        return $results;
    }
/*
    public function deleteUser($id){
        $id = (int)$id;
        User::destroy($id);

        return back()->with('success', 'Пользователь удален.');
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

    public function makeWorker($id)
    {
        $id = (int)$id;
        $user = User::find($id);

        if ($user){
            $companies = Company::where('is_delete',false)->get();
            return view('admin.makeWorker',['user' => $user,'companies'=>$companies]);
        }
        return abort(404);
    }

    public function makeWorkerAction(MakeWorkerRequest $request){
        $data = $request->only(['user_id','department','head','candidate']);

        (isset($data['head']))?($head = true):($head = false);
        (isset($data['candidate']))?($candidate = true):($candidate = false);
        $department = (int)$data['department'];
        $user_id = (int)$data['user_id'];
        if ($department) {
            $worker = new Worker();
            $worker->user_id = $user_id;
            $worker->department_id = $department;
            $worker->is_head = $head;
            $worker->is_candidate = $candidate;
            $worker->save();

            return back()->with('success', 'Пользователю установлен статус сотрудника.');
        }else{
            return back()->with('success', 'Необходимо выбрать подразделение.');
        }
    }

    public function deleteStatusWorker($user_id,$department_id)
    {
        $user_id = (int)$user_id;
        $department_id = (int)$department_id;

        Worker::where('user_id',$user_id)->where('department_id',$department_id)->first()->delete();

        return back()->with('success', 'Пользователь удалён из списка подразделения.');
    }

 /*   public function deleteStatusHRworker($user_id,$company_id)
    {
        $user_id = (int)$user_id;
        $company_id = (int)$company_id;

        HRworker::where('user_id',$user_id)->where('company_id',$company_id)->first()->delete();

        return back()->with('success', 'Пользователю удалён статус HR.');
    }

    public function department($id)
    {
        $id = (int)$id;
        $department = DB::table('departments')->select('departments.is_delete as is_delete','company_id','companies.name as company_name', 'departments.is_delete as is_delete','departments.id as department_id', 'departments.name as name')->where('departments.id','=',$id)->join('companies','departments.company_id','=','companies.id')->limit(1)->get();
        $workers = DB::table('workers')->join('users','workers.user_id','=','users.id')->where('workers.department_id','=',$id)->get();
        return view('admin.department', ['department'=>$department[0],'workers'=>$workers]);
    }
*/
}
