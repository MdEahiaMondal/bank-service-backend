<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed user_id
 * @property mixed name
 */
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:80|unique:users,email,'.$id,
            'phone' => 'nullable|string|max:20|min:5',
            'password' => 'required|string|max:20|min:8',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'status' => 'nullable|boolean',
            'bank_id' => 'required|integer',
            'designation' => 'required|string|max:255',
            'per_user_benefit' => 'required|integer',
        ];

        return $rules;
    }
}
