<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'nullable|alpha',
            'secondName' => 'required|alpha',
            'middleName' => 'nullable|alpha',
            'email'=>'required|email:rfc,dns|unique:users,email',
            'department' =>'required|integer|exists:departments,id',
            'company'=>'required|integer|exists:companies,id',
            'hr'=>'nullable|boolean',
            'head'=>'nullable|boolean',
            'candidate'=>'nullable|boolean',
            'phone'=>'nullable|regex:/^\+?[\(\)0-9 -]{1,40}$/i'
        ];
    }

    public function attributes()
    {
        return [
            'firstName' => '"Имя"',
            'secondName' => '"Фамилия"',
            'middleName' => '"Отчество"',
            'email'=>'"E-mail"',
            'department' =>'"Подразделение"',
            'company'=>'"Организация"',
            'phone'=>'"Телефон"'
        ];
    }
}
