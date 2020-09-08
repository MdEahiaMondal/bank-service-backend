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
        $id = isset($this->id) ? $this->id : null;
        $rules = [
            'name' => 'required|string|max:100|unique:users,name,'.$id,
            'email' => 'required|email|max:80|unique:users,email,'.$id,
            'phone' => 'nullable|string|max:20|min:5',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'status' => 'nullable|boolean',
            'bank_id' => 'required|integer',
            'designation' => 'required|string|max:255',
            'per_user_benefit' => 'required|integer',
        ];

        if (request()->isMethod('post'))
        {
            $rules['password'] = 'required|string|max:20|min:8';
        }

        return $rules;
    }
}
