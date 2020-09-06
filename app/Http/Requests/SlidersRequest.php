<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlidersRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rules = [
            'title' => 'required|max:255',
        ];
        if (request()->isMethod('post'))
        {
            $rules['photo'] = 'required|mimes:jpg,jpeg,bmp,png,gif,svg';
        }
        if (request()->isMethod('put') || request()->isMethod('patch'))
        {
            $rules['photo'] = 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg';
        }
        return $rules;
    }
}
