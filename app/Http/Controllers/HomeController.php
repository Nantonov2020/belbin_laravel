<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\HRworker;
use App\Services\HomeService;

class HomeController extends Controller
{

    public function __construct(HomeService $homeService)
    {
        $this->middleware('auth');
        $this->homeService = $homeService;
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

        $countCompaniesWithUserHasStatusHR = $this->homeService->giveCountCompanyWithUserHasStatusHR($user->email);

        if ($countCompaniesWithUserHasStatusHR > 1) {
            $companies = $this->homeService->giveCompaniesWithUserHasStatusHR($user->id);
            return view('hr.company', ['companies' => $companies]);
        }

        if ($countCompaniesWithUserHasStatusHR == 1) {
            $idCompany = HRworker::where('user_id',$user->id)->first();
            return redirect()->route('hr.index', ['idCompany' => $idCompany->company_id]);
        }

        $countQuestionnairiesOfUserWithUpdateIsFresh = $this->homeService->giveCountQuestionnairiesOfUserWithUpdateIsFresh($user->email);

        if ($countQuestionnairiesOfUserWithUpdateIsFresh < 1) {
            $this->homeService->storeNewQuestionnaire($user->id);
        }

        return redirect(route('user.index'));
    }
}
