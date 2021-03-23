<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\DeleteCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        return view('admin.index',['companies'=>Company::orderBy('is_delete', 'asc')
                                        ->paginate(config('app.pagination_companies'))]);
    }

    public function storeCompany(CompanyStoreRequest $request)
    {
        $nameNewCompany = $request->name;
        $this->companyService->storeCompany($nameNewCompany);

        return redirect()->route('admin')->with('success', 'Компания добавлена.');
    }

    public function updateCompany(CompanyStoreRequest $request, int $id)
    {
        $newNameCompany = $request->name;
        $this->companyService->updateNameCompany($newNameCompany, $id);

        return back()->with('success', 'Наименование скорректировано.');
    }

    public function showCompany(int $id)
    {
        list($company, $departments, $hrworkers) = $this->companyService->giveInfoAboutCompany($id);

        return view('admin.company',['company'=>$company, 'departments'=>$departments,'hrworkers'=>$hrworkers]);
    }

    public function findCompany(Request $request)
    {
        $name = $request->name;

        return view('admin.index',['companies'=>Company::where('name', 'like', "%$name%")
                                                            ->paginate(15)]);
    }

    public function deleteCompany(DeleteCompanyRequest $request)
    {
        $idCompany = $request->id;
        $this->companyService->deleteCompany($idCompany);

        return back();
    }

    public function restoreCompany(DeleteCompanyRequest $request)
    {
        $idCompany = $request->id;
        $this->companyService->restoreCompany($idCompany);

        return back();
    }

    public function showFormForRenameCompany(int $id)
    {
        return view('admin.renameCompany',['company'=>Company::find($id)]);
    }

}
