<?php


namespace App\Services;


use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function showAllDepartments()
    {
        $departments = DB::table('companies')
            ->orderBy('companies.id')
            ->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')
            ->join('departments','companies.id', '=', 'departments.company_id')
            ->paginate(config('app.pagination_departments'));

        return $departments;
    }

    public function showAllDepartmentsOfCompanyWithPanination(int $idCompany)
    {
        $departments =  Department::where('company_id',$idCompany)
            ->paginate(config('app.pagination_departments'));

        return $departments;
    }

    public function findDepartment($data)
    {
        $name = $data['name'];
        $departments = DB::table('companies')->orderBy('companies.id')
            ->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')
            ->where('departments.name', 'like', "%$name%")
            ->join('departments','companies.id', '=', 'departments.company_id')
            ->paginate(config('app.pagination_departments'))
            ->appends('name',$name);

        return $departments;
    }

    public function findDepartmentsOfCompany(int $idCompany, string $textForFindDepartments)
    {
        $departments = DB::table('companies')
            ->orderBy('companies.id')
            ->select('companies.id as idCompany','companies.name as nameCompany', 'departments.name','departments.id', 'departments.is_delete')
            ->where('departments.name', 'like', "%$textForFindDepartments%")
            ->where('departments.company_id','=',$idCompany)
            ->join('departments','companies.id', '=', 'departments.company_id')
            ->paginate(config('app.pagination_departments'))
            ->appends('name',$textForFindDepartments)
            ->appends('idCompany',$idCompany);

        return $departments;
    }

    public function deleteDepartment($data):void
    {
        $idDepartment = $data['id'];
        $this->takeStatusDeleteForDepartment($idDepartment, true);
    }

    public function restoreDepartment($data):void
    {
        $idDepartment = $data['id'];
        $this->takeStatusDeleteForDepartment($idDepartment, false);
    }

    private function takeStatusDeleteForDepartment(int $idDepartment, bool $status):void
    {
        $department = Department::find($idDepartment);
        $department->is_delete = $status;
        $department->save();
    }

    public function storeDepartment($data):void
    {
        $department = new Department();
        $department->name = $data['name'];
        $department->company_id = $data['company_id'];
        $department->save();
    }

    public function updateDepartment($newNameDepartment, $idDepartment):void
    {
        $department = Department::find($idDepartment);
        $department->name = $newNameDepartment;
        $department->save();
    }

    public function giveInfoAboutDepartment(int $idDepartment):array
    {
        $department = DB::table('departments')
            ->select('company_id','companies.name as company_name', 'departments.is_delete as is_delete','departments.id as department_id', 'departments.name as name')
            ->where('departments.id','=',$idDepartment)
            ->join('companies','departments.company_id','=','companies.id')
            ->limit(1)
            ->get();
        $workers = DB::table('workers')
            ->join('users','workers.user_id','=','users.id')
            ->where('workers.department_id','=',$idDepartment)
            ->get();

        return array($department, $workers);
    }

    public function giveSetDepartmentsForCompany(int $idCompany):array
    {
        $departments = Department::where('company_id',$idCompany)->get();
        $results = [];
        foreach ($departments as $department){
            $results[$department->id] = $department->name;
        }
        return $results;
    }
}
