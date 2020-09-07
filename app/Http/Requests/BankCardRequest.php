<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankCardRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];
        return $rules;
    }
}
