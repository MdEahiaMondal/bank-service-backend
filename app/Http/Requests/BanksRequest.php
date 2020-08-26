<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|max:255|unique:banks,name,'.$id,
            'location' => 'required|max:255',
        ];

       /* if (request()->isMethod('post'))
        {
            $rules['image'] = 'required|mimetypes:image/jpeg,image/png';
        }
        if (request()->isMethod('put') || request()->isMethod('patch'))
        {
            $rules['image'] = 'nullable|mimetypes:image/jpeg,image/png';
        }*/
        return $rules;

    }


/*// make custom message for validation
    public function messages()
    {
        return [
            'title.required' => 'The title must be need',
            'title.unique' => 'title must be unique',
            'image.required' => 'image need must',
        ];
    }*/

}
