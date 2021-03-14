<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorrectUserRequest extends FormRequest
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
            'email'=>'required|email:rfc,dns',
            'user_id' => 'required|integer'
        ];
    }
    public function attributes()
    {
        return [
            'firstName' => '"Имя"',
            'secondName' => '"Фамилия"',
            'middleName' => '"Отчество"',
            'email'=>'"E-mail"'
        ];
    }
}
