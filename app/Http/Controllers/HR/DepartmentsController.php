<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function showDepartments($idCompany){
        $idCompany = (int)$idCompany;
        $company = Company::find($idCompany);
        $departments =  Department::where('company_id',$idCompany)
                                    ->paginate(config('app.pagination_departments'));
        return view('hr.index',['company' => $company, 'departments' => $departments]);
    }
}
