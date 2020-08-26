<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BanksRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends ApiController
{

    public function index()
    {
        $banks = Bank::paginate(10);
        return $this->showDataResponse('banks',$banks);
    }


    public function store(BanksRequest $request)
    {
        $bank = new Bank();
        $bank->name = $request->name;
        $bank->location = $request->location;
        $bank->created_by =  Auth::id() ?? 0;
        $bank->updated_by =  Auth::id() ?? 0;
        $bank->status =  $request->status ?? 0;
        if ($bank->save()){
            return $this->showDataResponse('bank', $bank, 201);
        }
    }

    public function show(Bank $bank)
    {
        return $this->showDataResponse('bank', $bank, 200);
    }

    public function update(BanksRequest $request, Bank $bank)
    {
        $bank->name = $request->name;
        $bank->location = $request->location;
        $bank->updated_by = Auth::id() ?? 0;
        $bank->status =  $request->status ?? 0;
        if ($bank->save()){
            return $this->showDataResponse('bank', $bank, 200);
        }

    }


    public function destroy(Bank $bank)
    {
        $bank->delete();
        return $this->successResponse('Bank Deleted Success');
    }

}
