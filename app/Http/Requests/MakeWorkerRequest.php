<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeWorkerRequest extends FormRequest
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
            'department' =>'required|integer|exists:departments,id',
            'user_id' =>'required|integer|exists:users,id',
            'head'=>'nullable|boolean',
            'candidate'=>'nullable|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'department' =>'"Подразделение"',
        ];
    }
}
