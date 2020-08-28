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
        //$id = isset($this->cardOrLone) ? $this->cardOrLone->id : null;
        $rules = [
            'user_id' => 'required',
            'bank_id' => 'required',
            'phone'   => 'required|number,max:15',
            'office_name'    => 'required|string,max:255',
            'office_address' => 'required|max:255',
            'designation'  => 'required|max:255',
            'basic_salary' => 'required',
            'gross_salary' => 'required',
            'bank_loan'    => 'required',
            'loan_limit_amount' => 'required',
            'status' => 'required',
        ];

         if (request()->isMethod('post'))
         {
             $rules = [
                 'salary_certificate' => 'required|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'job_id_card'   => 'required|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'visiting_card' => 'required|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'nid_card'      => 'required|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
             ];
         }
         if (request()->isMethod('put') || request()->isMethod('patch'))
         {
             $rules = [
                 'salary_certificate' => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'job_id_card'   => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'visiting_card' => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'nid_card'      => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
             ];
         }

        return $rules;
    }
}
