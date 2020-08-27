<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BanksRequest;
use App\Models\Bank;
use App\Models\BankAdmin;
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
        $request['name'] = $request->name;
        $request['location'] = $request->location;
        $request['created_by'] =  Auth::id() ?? 0;
        $request['updated_by'] =  Auth::id() ?? 0;
        $request['status'] =  $request->status ?? 0;

        $only = $request->only('name', 'location', 'created_by', 'updated_by', 'status');
        $bank = Bank::create($only);

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
        $request['name'] = $request->name;
        $request['location'] = $request->location;
        $request['updated_by'] =  Auth::id() ?? 0;
        $request['status'] =  $request->status ?? 0;

        $only = $request->only('name', 'location', 'update_by', 'status');
        $bank->update($only);

        return $this->showDataResponse('bank', $bank, 200);
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return $this->successResponse('Bank Deleted Success');
    }

}
