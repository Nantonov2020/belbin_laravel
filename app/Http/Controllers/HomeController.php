<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\HRworker;
use App\Models\Questionnaire;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();

        if ($user->is_admin == 1)   {
            return view('admin.index',['companies'=>Company::orderBy('is_delete', 'asc')->paginate(config('app.pagination_companies'))]);
        }
        $userFromDB = DB::table('users')->where('email','=',$user->email)
                    ->join('hrworkers','users.id','=','hrworkers.user_id')->get();

        if ($userFromDB->count() > 0)    {
            if ($userFromDB->count() > 1){
                $companies = DB::table('companies')
                            ->select('companies.name as name', 'companies.id as id')
                            ->join('hrworkers','companies.id','=','hrworkers.company_id')
                            ->where('hrworkers.user_id','=', $user->id)->get();
                return view('hr.company', ['companies' => $companies]);
            }
            $idCompany = HRworker::where('user_id',$user->id)->first();
            //dd($idCompany);
            return redirect()->route('hr.index', ['idCompany' => $idCompany->company_id]);
        }

        $userFromDB = DB::table('users')->where('email','=',$user->email)
                    ->join('questionnaires','users.id','=','questionnaires.user_id')
                    ->where('questionnaires.updated_at','>', Carbon::now()->subDays(30))->get();

        if ($userFromDB->count() < 1)   {
            $userForWork = User::where('email',$user->email)->first();

            $questionnaire = new Questionnaire();
            $questionnaire->user_id = $userForWork->id;
            $questionnaire->results = '{}';
            $questionnaire->save();
        }
        return redirect(route('user.index'));
    }
}
