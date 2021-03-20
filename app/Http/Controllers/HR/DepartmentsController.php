<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    public function showDepartments(int $idCompany){
        $company = Company::find($idCompany);
        $departments =  Department::where('company_id',$idCompany)
                                    ->paginate(config('app.pagination_departments'));
        return view('hr.index',['company' => $company, 'departments' => $departments]);
    }

    public function showOneDepartment(int $idDepartment)
    {
        return view('hr.department');
    }

    public function findDepartment(Request $request, int $idCompany)
    {
        $textForFindDepartments = $request->name;

        $company = Company::find($idCompany);

        $departments = DB::table('companies')->orderBy('companies.id')
            ->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')
            ->where('departments.name', 'like', "%$textForFindDepartments%")
            ->where('departments.company_id','=',$idCompany)
            ->join('departments','companies.id', '=', 'departments.company_id')
            ->paginate(config('app.pagination_departments'))
            ->appends('name',$textForFindDepartments)
            ->appends('idCompany',$idCompany);

        return view('hr.index',['company' => $company, 'departments' => $departments]);
    }
}
