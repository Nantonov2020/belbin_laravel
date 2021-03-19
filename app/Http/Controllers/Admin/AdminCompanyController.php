<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\DeleteCompanyRequest;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCompanyController extends Controller
{
    public function index()
    {
        return view('admin.index',['companies'=>Company::orderBy('is_delete', 'asc')
                                        ->paginate(config('app.pagination_companies'))]);
    }

    public function storeCompany(CompanyStoreRequest $request)
    {
        $data = $request->only(['name']);

        $company = new Company();
        $company->name = $data['name'];
        $company->save();

        return redirect()->route('admin')->with('success', 'Компания добавлена.');
    }

    public function updateCompany(CompanyStoreRequest $request, int $id)
    {
        $data =  $request->only(['name']);

        $company = Company::find($id);
        $company->name = $data['name'];
        $company->save();

        return back()->with('success', 'Наименование скорректировано.');
    }

    public function showCompany(int $id)
    {
        $company = Company::find($id);
        $departments = Department::where('company_id',$id)
                                    ->get();
        $hrworkers = DB::table('users')->select('users.id as user_id','firstName', 'secondName','middleName', 'phone')
                                            ->join('hrworkers','users.id', '=', 'hrworkers.user_id')
                                            ->where('hrworkers.company_id','=',$id)->get();
        return view('admin.company',['company'=>$company, 'departments'=>$departments,'hrworkers'=>$hrworkers]);
    }

    public function findCompany(Request $request)
    {
        $data = $request->only(['name']);
        $name = $data['name'];

        return view('admin.index',['companies'=>Company::where('name', 'like', "%$name%")
                                                            ->paginate(15)]);
    }

    public function deleteCompany(DeleteCompanyRequest $request)
    {
        $data = $request->only(['id','type']);
        $id = $data['id'];
        $type = $data['type'];
        $company = Company::find($id);
        $company->is_delete = (bool)$type;
        $company->save();
        return back();
    }

    public function renameCompany(int $id)
    {
        return view('admin.renameCompany',['company'=>Company::find($id)]);
    }

}
