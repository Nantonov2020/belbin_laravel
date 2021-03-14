<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
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
        $tableNameCompany = (new Company())->getTable();
        return [
            'name' => "required|unique:{$tableNameCompany}|max:100|min:3",
        ];
    }
    public function attributes()
    {
        return [
            'name' => '"Наименование организации"'
        ];
    }

}
