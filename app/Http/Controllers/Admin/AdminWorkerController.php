<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MakeWorkerRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Worker;
use App\Services\WorkersService;

class AdminWorkerController extends Controller
{
    protected $workersService;

    public function __construct(WorkersService $workersService)
    {
        $this->workersService = $workersService;
    }

    public function showFormForMakeStatusWorker(int $idUser)
    {
        $user = User::find($idUser);

        if ($user){
            $companies = Company::where('is_delete',false)->cursor();
            return view('admin.makeWorker',['user' => $user,'companies'=>$companies]);
        }
        return abort(404);
    }

    public function makeStatusWorkerForUser(MakeWorkerRequest $request){
        $data = $request->only(['user_id','department','head','candidate']);

        $correctData = $this->workersService->makeCorrectDataForStatusWorkerForUser($data);

        if ($correctData['department']) {
            $this->workersService->makeStatusWorkerForUser($correctData);
            return back()->with('success', 'Пользователю установлен статус сотрудника.');
        }
            return back()->with('success', 'Необходимо выбрать подразделение.');
    }

    public function deleteStatusWorker(int $idUser, int $idDepartment)
    {
        Worker::where('user_id',$idUser)
                ->where('department_id',$idDepartment)
                ->first()
                ->delete();

        return back()->with('success', 'Пользователь удалён из списка подразделения.');
    }
}
