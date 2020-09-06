<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed name
 * @property mixed location
 */
class BanksRequest extends FormRequest
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

    public function rules()
    {
        $id = isset($this->bank) ? $this->bank->id : null;

        $rules = [
            'name' => 'required|max:255|unique:banks,name,' . $id,
            'location' => 'required|max:255',
        ];
        return $rules;
    }
}
