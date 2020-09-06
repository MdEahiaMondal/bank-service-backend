<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankCardTypesRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'bank_id' => 'required|integer',
        ];
        return $rules;
    }
}
