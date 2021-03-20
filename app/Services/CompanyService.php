<?php


namespace App\Services;


use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function storeCompany(string $nameNewCompany):void
    {
        $company = new Company();
        $company->name = $nameNewCompany;
        $company->save();
    }

    public function updateNameCompany(string $newNameCompany, int $idCompany):void
    {
        $company = Company::find($idCompany);
        $company->name = $newNameCompany;
        $company->save();
    }

    public function giveInfoAboutCompany($idCompany):array
    {
        $company = Company::find($idCompany);
        $departments = Department::where('company_id',$idCompany)
            ->cursor();

        $hrworkers = DB::table('users')->select('users.id as user_id','firstName', 'secondName','middleName', 'phone')
            ->join('hrworkers','users.id', '=', 'hrworkers.user_id')
            ->where('hrworkers.company_id','=',$idCompany)->cursor();

        return array($company, $departments, $hrworkers);
    }

    public function deleteCompany(int $idCompany):void
    {
        $company = Company::find($idCompany);
        $company->is_delete = true;
        $company->save();
    }

    public function restoreCompany(int $idCompany):void
    {
        $company = Company::find($idCompany);
        $company->is_delete = false;
        $company->save();
    }
}
