<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\CorrectUserRequest;
use App\Http\Requests\SearchUserRequest;
use App\Models\Company;
use App\Models\User;
use App\Services\UserService;


class AdminUsersController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showUsers()
    {
        return view('admin.users',['users'=>User::orderBy('updated_at', 'asc')->paginate(config('app.pagination_users'))]);
    }

    public function searchUser(SearchUserRequest $request){

        $data = $request->only(['firstName','secondName','middleName','email','attribute']);
        $users = $this->userService->searchUser($data);
        return view('admin.users', ['users'=>$users]);
    }

    public function addUserForm()
    {
        return view('admin.addUser',['companies'=>Company::where('is_delete', false)->get()]);
    }

    public function addUser(AddUserRequest $request){
        $data = $request->only(['email','secondName','firstName','middleName','department','company', 'hr', 'head', 'candidate','phone']);

        if ($this->userService->addUser($data)) {
            return back()->with('success', 'Пользователь добавлен.');
        }
        return abort(404);
    }

    public function deleteUser(int $idUser){
        User::destroy($idUser);

        return redirect()->route('admin.users');
    }

    public function showFormForCorrectUserInfo(int $idUser)
    {
        return view('admin.correctUser',['user' => User::find($idUser)]);
    }

    public function correctUserAction(CorrectUserRequest $request)
    {
        $data = $request->only(['user_id','email','secondName','firstName','middleName']);
        if ($this->userService->correctUser($data)) {
            return back()->with('success', 'Данные скорректированы.');
        }
        return back()->with('success', 'Произошла ошибка. Данные не изменены.');
    }

    public function showUser(int $idUser)
    {
        $user = User::find($idUser);
        if ($user) {
            list($worker, $HRworker) = $this->userService->giveInformationAboutUser($idUser);
            return view('admin.user',['user' => $user, 'worker'=>$worker, 'HRworker'=>$HRworker]);
        }
            return abort(404);
    }

    public function makeStatusAdmin(int $idUser)
    {
        $this->userService->giveStatusAdminToUser($idUser);
        return back()->with('success', 'Пользователю присвоен статус Администратора.');
    }

    public function deleteStatusAdmin(int $idUser)
    {
        $this->userService->deleteStatusAdminToUser($idUser);
        return back()->with('success', 'Пользователь лишен статуса Администратора.');
    }
}
