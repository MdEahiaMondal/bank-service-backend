<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CommonController;
use App\Http\Requests\LoansRequest;
use App\Models\Bank;
use App\Models\Loan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoanController extends ApiController
{
    public function index()
    {
        $card_or_loans = Loan::paginate(10);
        return $this->showDataResponse('card_or_loans', $card_or_loans);
    }


    public function getAllBank()
    {
        $banks = Bank::active()
            ->select(['name', 'id'])
            ->get();
        return $this->showDataResponse('card_or_load_banks', $banks, 200);
    }

    public function store(LoansRequest $request, User $user)
    {
        return $request->all();

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

        $loan = Loan::create($only);

        return $this->showDataResponse('cardOrLoan', $loan, 201);
    }

    public function show(Loan $loan)
    {
        return $this->showDataResponse('cardOrLoan', $loan, 200);
    }

    public function update(LoansRequest $request, Loan $loan)
    {
        $slug = Str::slug($request->office_name);

        if($request->hasFile('salary_certificate')){
            $file = $request->file('salary_certificate_test');
            //get old file
            $oldFile = $loan->salary_certificate;
            $file_name = CommonController::PdfFileUpload($file, $slug, $oldFile);
            $request['salary_certificate'] = $file_name;
        }

        if($request->hasFile('job_id_card')){
            $file = $request->file('job_id_card');
            //get old file
            $oldFile = $loan->job_id_card;
            $file_name = CommonController::PdfFileUpload($file, $slug, $oldFile);
            $request['job_id_card'] = $file_name;
        }

        if($request->hasFile('visiting_card')){
            $file = $request->file('visiting_card');
            //get old file
            $oldFile = $loan->visiting_card;
            $file_name = CommonController::PdfFileUpload($file, $slug, $oldFile);
            $request['visiting_card'] = $file_name;
        }


        if($request->hasFile('nid_card')){
            $file = $request->file('nid_card');
            //get old file
            $oldFile = $loan->nid_card;
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

        $loan->update($only);

        return $this->showDataResponse('cardOrLoan', $loan,201);
    }

    public function destroy(Loan $loan)
    {
        $directory = public_path().'/storage/Uploaded_files/';
        if ($loan->salary_certificate) {
            CommonController::deleteFile($loan->salary_certificate, $directory);
        }
        if ($loan->job_id_card) {
            CommonController::deleteFile($loan->job_id_card, $directory);
        }
        if ($loan->visiting_card) {
            CommonController::deleteFile($loan->visiting_card, $directory);
        }
        if ($loan->nid_card) {
            CommonController::deleteFile($loan->nid_card, $directory);
        }

        $loan->delete();
        return $this->successResponse('Slider deleted success');
    }
}
