<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Requests\findDepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function showDepartments(int $idCompany){
        $company = Company::find($idCompany);
        $departments =  $this->departmentService->showAllDepartmentsOfCompanyWithPanination($idCompany);

        return view('hr.index',['company' => $company, 'departments' => $departments]);
    }

    public function showOneDepartment(int $idDepartment)
    {
        list($department, $workers) = $this->departmentService->giveInfoAboutDepartment($idDepartment);
        return view('hr.department',['department' => $department[0], 'workers' => $workers]);
    }

    public function findDepartment(findDepartmentRequest $request, int $idCompany)
    {
        $textForFindDepartments = $request->name;

        $company = Company::find($idCompany);
        $departments = $this->departmentService->findDepartmentsOfCompany($idCompany, $textForFindDepartments);

        return view('hr.index',['company' => $company, 'departments' => $departments]);
    }

    public function deleteDepartment(int $idDepartment)
    {
        $this->departmentService->deleteDepartment(['id' => $idDepartment]);
        return back()->with('success', 'Подразделение удалено.');;
    }

    public function restoreDepartment(int $idDepartment)
    {
        $this->departmentService->restoreDepartment(['id' => $idDepartment]);

        return back()->with('success', 'Подразделение восстановлено.');;
    }

    public function showFormForAddDepartment(int $idCompany)
    {
        return view('hr.adddepartment',['idCompany' => $idCompany]);
    }

    public function storeDepartment(DepartmentStoreRequest $request, int $idCompany)
    {
        $data = $request->only(['name', 'company_id']);
        $this->departmentService->storeDepartment($data);

        return redirect()->back()->with('success', 'Подразделение добавлено.');
    }

    public function showFormForRenameDapartment(int $idDepartment)
    {
        $department = Department::find($idDepartment);
        return view('hr.renamedepartment',['department' => $department]);
    }

    public function updateDepartment(DepartmentUpdateRequest $request,int $idDepartment)
    {
        $newNameDepartment = $request->name;
        $this->departmentService->updateDepartment($newNameDepartment, $idDepartment);

        return redirect()->back()->with('success', 'Наименование подразделения скорректировано.');
    }
}
