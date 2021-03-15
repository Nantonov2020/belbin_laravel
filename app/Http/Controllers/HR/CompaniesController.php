<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index($id){
        $company = Company::find($id);
        $departments =  Department::where('company_id',$id)->get();
        return view('hr.index',['company' => $company, 'departments' => $departments]);
    }
}
