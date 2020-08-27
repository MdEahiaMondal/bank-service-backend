<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CommonController;
use App\Models\CardOrLoan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class CardOrLoanController extends ApiController
{

    public function index()
    {
        $card_or_loans = CardOrLoan::paginate(10);
        return $this->showDataResponse('card_or_loans', $card_or_loans);
    }

    public function store(CardOrLoan $request)
    {
        $slug = Str::slug($request->office_name);
        if(
            $request->hasFile('salary_certificate') && $request->hasFile('job_id_card') &&
            $request->hasFile('visiting_card') && $request->hasFile('nid_card')
        ) {
            $files = [
                'salary_certificate' => $request->file('salary_certificate'),
                'job_id_card' => $request->file('job_id_card'),
                'visiting_card' => $request->file('visiting_card'),
                'nid_card' => $request->file('nid_card')
            ];

            $file_name = CommonController::PdfFileUpload($files, $slug,  'Uploaded_files');
        }
    }

    public function show(CardOrLoan $cardOrLone)
    {
        //
    }


    public function update(Request $request, CardOrLoan $cardOrLone)
    {
        //
    }

    public function destroy(CardOrLoan $cardOrLone)
    {
        //
    }
}
