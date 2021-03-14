<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MakeWorkerRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;

class AdminWorkerController extends Controller
{
    public function makeWorker($id)
    {
        $id = (int)$id;
        $user = User::find($id);

        if ($user){
            $companies = Company::where('is_delete',false)->get();
            return view('admin.makeWorker',['user' => $user,'companies'=>$companies]);
        }
        return abort(404);
    }

    public function makeWorkerAction(MakeWorkerRequest $request){
        $data = $request->only(['user_id','department','head','candidate']);

        (isset($data['head']))?($head = true):($head = false);
        (isset($data['candidate']))?($candidate = true):($candidate = false);
        $department = (int)$data['department'];
        $user_id = (int)$data['user_id'];
        if ($department) {
            $worker = new Worker();
            $worker->user_id = $user_id;
            $worker->department_id = $department;
            $worker->is_head = $head;
            $worker->is_candidate = $candidate;
            $worker->save();

            return back()->with('success', 'Пользователю установлен статус сотрудника.');
        }else{
            return back()->with('success', 'Необходимо выбрать подразделение.');
        }
    }

    public function deleteStatusWorker($user_id,$department_id)
    {
        $user_id = (int)$user_id;
        $department_id = (int)$department_id;

        Worker::where('user_id',$user_id)->where('department_id',$department_id)->first()->delete();

        return back()->with('success', 'Пользователь удалён из списка подразделения.');
    }

}
