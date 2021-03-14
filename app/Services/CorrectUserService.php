<?php


namespace App\Services;

use App\Models\User;

class CorrectUserService
{
    public function make($data)
    {
        $email = $data['email'];
        $user_id = (int)$data['user_id'];
        $secondName = $data['secondName'];
        $firstName = $data['firstName'];
        $middleName = $data['middleName'];

        $user = User::find($user_id);
        $user->email = $email;
        $user->secondName = $secondName;
        $user->firstName = $firstName;
        $user->middleName = $middleName;
        $user->save();

        return true;
    }
}
