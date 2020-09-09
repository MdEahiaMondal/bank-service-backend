<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoansRequest extends FormRequest
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

        $request = request();

        $rules = [
            'a_t' => 'required|max:100',
            'apply_for' => 'required|max:100',
            'bank_id' => 'required',
            'basic_salary' => 'required|integer',
            'gross_salary' => 'required|integer',
            'salary_payment_by_bank' => 'required|max:255',
            'cash_payment_by_bank' => 'required|max:255',
            'designation' => 'required|max:255',
            'loan_limit_amount' => 'required|integer',
            'office_address' => 'required|max:255',
            'office_name' => 'required|max:255',
        ];

        info($request->want_to_loan);
        if ($request->want_to_loan === 'true'){
            $rules['secondary_bank_address'] = 'required|max:255';
            $rules['secondary_bank_amount'] = 'required|integer';
            $rules['secondary_bank_name'] = 'required|max:255';
        }


         if (request()->isMethod('post'))
         {
             $rules['salary_certificate'] = 'required|mimes:pdf,jpeg,png,jpg|max:1024';
             $rules['tin_certificate'] = 'required|mimes:pdf,jpeg,png,jpg|max:1024';
             $rules['nid_card_front'] = 'required|mimes:pdf,jpeg,png,jpg|max:1024';
             $rules['nid_card_back'] = 'required|mimes:pdf,jpeg,png,jpg|max:1024';
             $rules['job_id_card'] = 'required|mimes:pdf,jpeg,png,jpg|max:1024';
             $rules['visiting_card'] = 'required|mimes:pdf,jpeg,png,jpg|max:1024';
         }

        /* if (request()->isMethod('put') || request()->isMethod('patch'))
         {
             $rules = [
                 'salary_certificate' => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'job_id_card'   => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'visiting_card' => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
                 'nid_card'      => 'nullable|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif,svg|max:1024',
             ];
         }*/

        return $rules;
    }


  /*  // make custom message for validation
    public function messages()
    {
        return [
            'title.required' => 'The title must be need',
            'title.unique' => 'title must be unique',
            'image.required' => 'image need must',
        ];
    }
    */
}
