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

        return view('hr.HRWorkers',['HRWorkers' => $HRWorkers]);
    }
}
