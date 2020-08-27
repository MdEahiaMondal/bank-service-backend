<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardOrLoansRequest extends FormRequest
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
        $id = isset($this->cardOrLone) ? $this->cardOrLone->id : null;
        $rules = [
            'user_id' => 'request',
            'bank_id' => 'request',
            'phone'   => 'request|number,max:15',
            'office_name'    => 'request|string,max:255',
            'office_address' => 'request|max:255',
            'designation'  => 'request|max:255',
            'basic_salary' => 'request',
            'gross_salary' => 'request',
            'bank_loan'    => 'request',
            'loan_limit_amount' => 'request',
        ];

         if (request()->isMethod('post'))
         {
             $rules = [
                 'salary_certificate' => 'required|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
                 'job_id_card'   => 'required|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
                 'visiting_card' => 'required|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
                 'nid_card'      => 'required|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
             ];
         }
         if (request()->isMethod('put') || request()->isMethod('patch'))
         {
             $rules = [
                 'salary_certificate' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
                 'job_id_card'   => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
                 'visiting_card' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
                 'nid_card'      => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf,txt,doc',
             ];
         }

        return $rules;
    }
}
