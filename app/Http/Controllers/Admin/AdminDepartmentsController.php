<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCompanyRequest;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Requests\findDepartmentRequest;
use App\Models\Company;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class AdminDepartmentsController extends Controller
{
    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function showDepartments()
    {
        $departments = $this->departmentService->showAllDepartments();

        return view('admin.departments',['departments'=>$departments]);
    }

    public function findDepartment(findDepartmentRequest $request)
    {
        $data = $request->only(['name']);
        $departments = $this->departmentService->findDepartment($data);

        return view('admin.departments',['departments'=>$departments]);
    }

    public function deleteDepartment(DeleteCompanyRequest $request)
    {
        $data = $request->only(['id']);
        $this->departmentService->deleteDepartment($data);

        return back();
    }

    public function restoreDepartment(DeleteCompanyRequest $request)
    {
        $data = $request->only(['id']);
        $this->departmentService->restoreDepartment($data);

        return back();
    }

    public function addDepartment()
    {
        return view('admin.addDepartment',['companies'=>Company::where('is_delete', false)->cursor()]);
    }

    public function storeDepartment(DepartmentStoreRequest $request)
    {
        $data = $request->only(['name', 'company_id']);
        $this->departmentService->storeDepartment($data);

        return redirect()->back()->with('success', 'Подразделение добавлено.');
    }

    public function updateDepartment(DepartmentUpdateRequest $request, int $id)
    {
        $data = $request->only(['name']);
        $this->departmentService->updateDepartment($data['name'], $id);

        return redirect()->back()->with('success', 'Наименование подразделения скорректировано.');
    }

    public function renameDepartment(int $id)
    {
        return view('admin.renameDepartment',['department'=>Department::find($id)]);
    }

    public function showDepartment(int $id)
    {
        $idDepartment = (int)$id;

        list ($department, $workers) = $this->departmentService->giveInfoAboutDepartment($idDepartment);

        return view('admin.department', ['department'=>$department[0],'workers'=>$workers]);
    }

    public function giveSetDepartmentsForCompany(Request $request) //Ajax
    {
        $data = $request->only(['id']);
        $results = $this->departmentService->giveSetDepartmentsForCompany($data['id']);

        return $results;
    }

}
