<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchUserRequest extends FormRequest
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
            'secondName' => 'nullable|alpha',
            'middleName' => 'nullable|alpha',
            'attribute' => 'required|integer',
            'email'=>'nullable|regex:/^[a-zа-яё -_\.@]{0,100}$/i'
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
