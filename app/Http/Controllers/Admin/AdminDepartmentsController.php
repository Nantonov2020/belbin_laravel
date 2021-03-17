<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCompanyRequest;
use App\Http\Requests\findDepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDepartmentsController extends Controller
{
    public function departments()
    {
        $departments = DB::table('companies')->orderBy('companies.id')
                    ->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')
                    ->join('departments','companies.id', '=', 'departments.company_id')->paginate(config('app.pagination_departments'));

        return view('admin.departments',['departments'=>$departments]);
    }
    public function findDepartment(findDepartmentRequest $request)
    {
        $data = $request->only(['name']);
        $name = $data['name'];
        $departments = DB::table('companies')->orderBy('companies.id')
                    ->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')
                    ->where('departments.name', 'like', "%$name%")
                    ->join('departments','companies.id', '=', 'departments.company_id')
                    ->paginate(config('app.pagination_departments'))
                    ->appends('name',$name);
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

    public function department($id)
    {
        $id = (int)$id;
        $department = DB::table('departments')
            ->select('company_id','companies.name as company_name', 'departments.is_delete as is_delete','departments.id as department_id', 'departments.name as name')
            ->where('departments.id','=',$id)->join('companies','departments.company_id','=','companies.id')
            ->limit(1)->get();
        $workers = DB::table('workers')->join('users','workers.user_id','=','users.id')
                    ->where('workers.department_id','=',$id)->get();
        return view('admin.department', ['department'=>$department[0],'workers'=>$workers]);
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

}
