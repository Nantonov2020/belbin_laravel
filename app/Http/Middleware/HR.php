<?php

namespace App\Http\Middleware;

use App\Models\Department;
use App\Models\HRworker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HR
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $idCompany = $request->idCompany;
        $idDepartment = $request->idDepartment;
        $idWorker = $request->idWorker;

        if (($idCompany == null)and($idDepartment == null)and($idWorker == null))   {
            return abort(404);
        }

        $user = \Auth::user();

        if (!($this->userIsHR($user->id))) {
            return abort(404);
        }

        if ($idWorker != null){
            $idWorker = (int)$idWorker;
            $checkNumberHR= DB::table('workers')
                                ->select('hrworkers.id')
                                ->join('departments','workers.department_id','=','departments.id')
                                ->join('companies', 'departments.company_id','=','companies.id')
                                ->join('hrworkers','companies.id','=','hrworkers.company_id')
                                ->where('workers.user_id','=',$idWorker)
                                ->where('hrworkers.user_id','=',$user->id)
                                ->get();
            if (count($checkNumberHR) == 0){
                return abort(404);
            }else{
                return $next($request);
            }
        }

        if ($idDepartment != null){
            $idDepartment = (int)$idDepartment;
            $idCompany = (Department::find($idDepartment))->company_id;
        }

        if ($idCompany != null) {
            $idCompany = (int)$idCompany;
            $isThisHRfromThisCompany = HRworker::where('user_id',$user->id)
                                                ->where('company_id',$idCompany)
                                                ->get();
            if(count($isThisHRfromThisCompany) == 0) {
                return abort(404);
            }
        }

        return $next($request);
    }

    private function userIsHR(int $idUser)
    {
        $result = true;
        $positionsInHRList = HRworker::where('user_id',$idUser)->get();

        if(count($positionsInHRList) == 0) {
            $result = false;
        }
        return $result;
    }
}
