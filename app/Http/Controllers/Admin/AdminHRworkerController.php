<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\HRService;

class AdminHRworkerController extends Controller
{
    protected $HRService;

    public function __construct(HRService $HRService)
    {
        $this->HRService = $HRService;
    }

    public function giveStatusHR(int $id){
        return view('admin.giveStatusHR',['user' => User::find($id), 'companies' => Company::where('is_delete', false)->cursor()]);
    }

    public function giveStatusHRAction(Request $request)
    {
        $idUser = (int)$request->user_id;
        $idCompany = (int)$request->company;

        if ($idCompany) {
            $this->HRService->giveStatusHRforUser($idUser, $idCompany);

            return back()->with('success', 'Пользователю присвоен статус HR.');
        }
        return back()->with('success', 'Не указана организация.');
    }

    public function deleteStatusHRworker(int $idUser,int $idCompany)
    {
        $this->HRService->deleteStatusHRworker($idUser,$idCompany);

        return back()->with('success', 'У пользователя удалён статус HR.');
    }

    public function showAllHRworkers()
    {
        $HRworkers = $this->HRService->giveInformationAboutAllHRWorkers();

        return view('admin.HRworkers',['HRworkers' => $HRworkers]);
    }
}
