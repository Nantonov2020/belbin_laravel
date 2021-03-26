<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Services\HRService;

class HRWorkersController extends Controller
{
    protected $HRService;

    public function __construct(HRService $HRService)
    {
        $this->HRService = $HRService;
    }

    public function showAllHRWorkersOfCompany(int $idCompany)
    {
        $HRWorkers = $this->HRService->giveInformationAboutAllHRByIdCompany($idCompany);

        return view('hr.HRWorkers',['HRWorkers' => $HRWorkers, 'idCompany' => $idCompany]);
    }

    public function deleteStatusHR(int $idUser, int $idCompany)
    {
        $user = \Auth::user();
        if ($user->id == $idUser){
            return back()->with('success', 'Нельзя снимать статус HR у самого себя.');
        }
        $this->HRService->deleteStatusHRworker($idUser, $idCompany);

        return back()->with('success', 'У пользователя снят статус HR');
    }

}
