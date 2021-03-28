<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = \Auth::user();

        $workers = DB::table('users')->select('companies.name as name','departments.name as name_department','is_head','is_candidate')->where('users.id','=',$user->id)->join('workers','users.id','=','workers.user_id')->join('departments','workers.department_id','=','departments.id')->join('companies','departments.company_id','=','companies.id')->get();
        $questionnaires = DB::table('users')->select('questionnaires.updated_at as updated_at','status','results')->where('users.id','=',$user->id)->join('questionnaires','users.id','=','questionnaires.user_id')->orderBy('questionnaires.updated_at', 'desc')->first();
        $nextData = Carbon::createFromTimeString($questionnaires->updated_at)->addDays(30);

        return view('worker.index',['user' => $user, 'workers'=>$workers,'questionnaires'=>$questionnaires,'nextData'=>$nextData]);
    }

}
