<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddWorkerRequest;
use App\Models\Department;
use App\Services\UserService;
use App\Services\WorkersService;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
    protected $workersService;
    protected $userService;

    public function __construct(WorkersService $workersService, UserService $userService)
    {
        $this->workersService = $workersService;
        $this->userService = $userService;
    }

   public function showAllWorkers(int $idCompany)
   {
       $workers = $this->workersService->giveAllWorkersOfCompanyWithPaginate($idCompany);
       return view('hr.workers', ['workers' => $workers, 'idCompany' => $idCompany]);
   }

   public function searchWorkers(Request $request, int $idCompany)
   {
       $data = $request->only(['email','secondName','firstName','middleName','attribute']);
       $workers = $this->workersService->searchWorkersOfCompanyWithPaginate($data, $idCompany);
       return view('hr.workers', ['workers' => $workers, 'idCompany' => $idCompany]);
   }

   public function showOneWorker(int $idWorker)
   {
       list($user, $worker, $HRworker) = $this->workersService->giveInformationAboutOneWorker($idWorker);

       return view('hr.worker',['user' => $user, 'worker'=>$worker, 'HRworker'=>$HRworker]);
   }

   public function showFormForAddWorker(int $idCompany)
   {
       $departments = Department::where('company_id', $idCompany)->cursor();
       return view('hr.addWorker',['idCompany' => $idCompany, 'departments' => $departments]);
   }

   public function storeWorker(AddWorkerRequest $request, int $idCompany)
   {
       $data = $request->only(['email','secondName','firstName','middleName','department', 'hr', 'head', 'candidate','phone']);
       $data['company'] = $idCompany;

       if ($this->userService->addUser($data)) {
           return back()->with('success', 'Пользователь добавлен.');
       }
       return abort(404);
   }

   public function showFormForFindUser(int $idCompany)
   {
       return view('hr.findUser',['idCompany' => $idCompany]);
   }
}
