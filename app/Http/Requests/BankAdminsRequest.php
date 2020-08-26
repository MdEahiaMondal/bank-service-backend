<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAdminsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $id = isset($this->bankAdmin) ? $this->bankAdmin->id : null;
        $rules = [
            'bank_id' => 'required',
            'name' => 'required|string|max:255|unique:bank_admins,name,'.$id,
            'designation' => 'required|string|max:255',
            'per_user_benefit' => 'required',
        ];

        return $rules;
    }
}
