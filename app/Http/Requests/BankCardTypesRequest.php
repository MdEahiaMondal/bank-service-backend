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
        $id = isset($this->bankCardTypeController) ? $this->bankCardTypeController->id : null;
        $rules = [
            'name' => 'required|string|max:255|unique:bank_card_types,name,'.$id,
        ];

        return $rules;
    }
}
