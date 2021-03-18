<?php

namespace App\Http\Middleware;

use App\Models\Department;
use App\Models\HRworker;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HR
{

    private $idCompany;
    private $idDepartment;
    private $idWorker;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->idCompany = $request->idCompany;
        $this->idDepartment = $request->idDepartment;
        $this->idWorker = $request->idWorker;

        if ($this->checkNotAvailabilityValues()){
            return abort(404);
        }

        $user = \Auth::user();

        if (!($this->userIsHR($user->id))) {
            return abort(404);
        }

        if ($this->idWorker != null){
            if ($this->hasHRAccessToWorkerID($user->id)){
                return $next($request);
            }
            return abort(404);
        }

        if ($this->idDepartment != null){
            $this->idDepartment = (int)$this->idDepartment;
            $this->idCompany = (Department::find($this->idDepartment))->company_id;
        }

        if ($this->idCompany != null) {

            if ($this->hasHRAccessToCompanyID($user->id)){
                return $next($request);
            }
            return $next($request);
        }
    }

    private function checkNotAvailabilityValues()
    {
        $result = false;
        if (($this->idCompany == null)and($this->idDepartment == null)and($this->idWorker == null))  {
            $result = true;
        }

        return $result;
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

    private function hasHRAccessToWorkerID($userId){
        $result = false;
        $this->idWorker = (int)$this->idWorker;
        $checkNumberHR= DB::table('workers')
            ->select('hrworkers.id')
            ->join('departments','workers.department_id','=','departments.id')
            ->join('companies', 'departments.company_id','=','companies.id')
            ->join('hrworkers','companies.id','=','hrworkers.company_id')
            ->where('workers.user_id','=',$this->idWorker)
            ->where('hrworkers.user_id','=',$userId)
            ->get();
        if (count($checkNumberHR) > 0){
            $result = true;
        }
        return $result;
    }

    private function hasHRAccessToCompanyID($userId){
        $result = false;
        $this->idCompany = (int)$this->idCompany;
        $isThisHRfromThisCompany = HRworker::where('user_id',$userId)
            ->where('company_id',$this->idCompany)
            ->get();
        if(count($isThisHRfromThisCompany) > 0) {
            $result = true;
        }

        return $result;
    }

}
