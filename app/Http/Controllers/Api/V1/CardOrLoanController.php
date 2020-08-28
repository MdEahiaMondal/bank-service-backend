<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CommonController;
use App\Http\Requests\CardOrLoansRequest;
use App\Models\CardOrLoan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CardOrLoanController extends ApiController
{

    public function index()
    {
        $card_or_loans = CardOrLoan::paginate(10);
        return $this->showDataResponse('card_or_loans', $card_or_loans);
    }

    public function store(CardOrLoansRequest $request)
    {
        $slug = Str::slug($request->office_name);

        if($request->hasFile('salary_certificate')){
            $file = $request->file('salary_certificate_test');
            $file_name = CommonController::PdfFileUpload($file, $slug);
            $request['salary_certificate'] = $file_name;
        }

        if($request->hasFile('job_id_card')){
            $file = $request->file('job_id_card');
            $file_name = CommonController::PdfFileUpload($file, $slug);
            $request['job_id_card'] = $file_name;
        }

        if($request->hasFile('visiting_card')){
            $file = $request->file('visiting_card');
            $file_name = CommonController::PdfFileUpload($file, $slug);
            $request['visiting_card'] = $file_name;
        }


        if($request->hasFile('nid_card')){
            $file = $request->file('nid_card');
            $file_name = CommonController::PdfFileUpload($file, $slug);
            $request['nid_card'] = $file_name;
        }

        $request['user_id'] = $request->user_id;
        $request['bank_id'] = $request->bank_id;
        $request['phone']   = $request->phone;
        $request['office_name']    = $request->office_name;
        $request['office_address'] = $request->office_address;
        $request['designation']    = $request->designation;
        $request['basic_salary']   = $request->basic_salary;
        $request['gross_salary']   = $request->gross_salary;
        $request['bank_loan']      = $request->bank_loan;
        $request['loan_limit_amount'] = $request->loan_limit_amount;
        $request['created_by'] = Auth::id() ?? 0;
        $request['updated_by'] = Auth::id() ?? 0;
        $request['status'] = $request->status ?? 0;

        $only = $request->only(
            'user_id', 'status', 'bank_id', 'phone', 'office_name', 'office_address', 'designation',
            'basic_salary', 'gross_salary',  'bank_loan', 'loan_limit_amount', 'salary_certificate', 'job_id_card',
            'visiting_card', 'nid_card', 'created_by', 'updated_by'
        );

        $cardOrLoan = CardOrLoan::create($only);

        return $this->showDataResponse('cardOrLoan', $cardOrLoan, 201);
    }

    public function show(CardOrLoan $cardOrLoan)
    {
        return $this->showDataResponse('cardOrLoan', $cardOrLoan, 200);
    }

    public function update(CardOrLoansRequest $request, CardOrLoan $cardOrLoan)
    {
        $slug = Str::slug($request->office_name);

        if($request->hasFile('salary_certificate')){
            $file = $request->file('salary_certificate_test');
            //get old file
            $oldFile = $cardOrLoan->salary_certificate;
            $file_name = CommonController::PdfFileUpload($file, $slug, $oldFile);
            $request['salary_certificate'] = $file_name;
        }

        if($request->hasFile('job_id_card')){
            $file = $request->file('job_id_card');
            //get old file
            $oldFile = $cardOrLoan->job_id_card;
            $file_name = CommonController::PdfFileUpload($file, $slug, $oldFile);
            $request['job_id_card'] = $file_name;
        }

        if($request->hasFile('visiting_card')){
            $file = $request->file('visiting_card');
            //get old file
            $oldFile = $cardOrLoan->visiting_card;
            $file_name = CommonController::PdfFileUpload($file, $slug, $oldFile);
            $request['visiting_card'] = $file_name;
        }


        if($request->hasFile('nid_card')){
            $file = $request->file('nid_card');
            //get old file
            $oldFile = $cardOrLoan->nid_card;
            $file_name = CommonController::PdfFileUpload($file, $slug, $oldFile);
            $request['nid_card'] = $file_name;
        }


        $request['user_id'] = $request->user_id;
        $request['bank_id'] = $request->bank_id;
        $request['phone']   = $request->phone;
        $request['office_name']    = $request->office_name;
        $request['office_address'] = $request->office_address;
        $request['designation']    = $request->designation;
        $request['basic_salary']   = $request->basic_salary;
        $request['gross_salary']   = $request->gross_salary;
        $request['bank_loan']      = $request->bank_loan;
        $request['loan_limit_amount'] = $request->loan_limit_amount;
        $request['updated_by'] = Auth::id() ?? 0;
        $request['status'] = $request->status ?? 0;

        $only = $request->only(
            'user_id', 'status', 'bank_id', 'phone', 'office_name', 'office_address', 'designation',
            'basic_salary', 'gross_salary',  'bank_loan', 'loan_limit_amount', 'salary_certificate', 'job_id_card',
            'visiting_card', 'nid_card', 'updated_by'
        );

        $cardOrLoan->update($only);

        return $this->showDataResponse('cardOrLoan', $cardOrLoan,201);
    }

    public function destroy(CardOrLoan $cardOrLoan)
    {
        $directory = public_path().'/storage/Uploaded_files/';
        if ($cardOrLoan->salary_certificate) {
            CommonController::deleteFile($cardOrLoan->salary_certificate, $directory);
        }
        if ($cardOrLoan->job_id_card) {
            CommonController::deleteFile($cardOrLoan->job_id_card, $directory);
        }
        if ($cardOrLoan->visiting_card) {
            CommonController::deleteFile($cardOrLoan->visiting_card, $directory);
        }
        if ($cardOrLoan->nid_card) {
            CommonController::deleteFile($cardOrLoan->nid_card, $directory);
        }

        $cardOrLoan->delete();
        return $this->successResponse('Slider deleted success');
    }
}
