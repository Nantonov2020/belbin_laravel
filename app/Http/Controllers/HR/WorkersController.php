<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\WorkersService;
use Illuminate\Support\Facades\DB;

class WorkersController extends Controller
{
    public function __construct(WorkersService $workersService)
    {
        $this->workersService = $workersService;
    }

   public function showAllWorkers(int $idCompany)
   {
       $workers = $this->workersService->giveAllWorkersOfCompanyWithPaginate($idCompany);
       return view('hr.workers', ['workers' => $workers]);
   }

   public function showOneWorker(int $idWorker)
   {
        $user = User::find($idWorker);
        $worker = DB::table('workers')
                ->select('company_id','companies.name as name','is_head', 'is_candidate','departments.name as name_department','departments.id as id_department')
                ->where('workers.user_id',$idWorker)
                ->join('departments','workers.department_id', '=', 'departments.id')
                ->join('companies', 'departments.company_id', '=', 'companies.id')
                ->get();
            $HRworker = DB::table('hrworkers')
                ->select('company_id','companies.name as name')
                ->where('hrworkers.user_id',$idWorker)
                ->join('companies','hrworkers.company_id', '=', 'companies.id')
                ->get();

       return view('hr.worker',['user' => $user, 'worker'=>$worker, 'HRworker'=>$HRworker]);
   }
}
