<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Services\BelbinService;

class BelbinController extends Controller
{
    protected $belbinService;

    public function __construct(BelbinService $belbinService)
    {
        $this->belbinService = $belbinService;
    }
    public function showResultsBelbinTestForDepartment(int $idDepartment)
    {
        list($department, $questionaries, $averageResults) = $this->belbinService->giveInformationAboutQuestionnariesOfUsersOfDepartmentWithInfoAboutDepartment($idDepartment);

        return view('hr.resultsBelbin',['department' => $department, 'questionaries' => $questionaries, 'averageResults' => $averageResults]);
    }

    public function showResultsBelbinTestForUser(int $idWorker)
    {
        list($user, $questionaries) = $this->belbinService->makeDataForShowResultsBelbinForUser($idWorker);

        return view('hr.showResultsBelbinForUser', ['user' => $user, 'questionaries' => $questionaries]);
    }

}
