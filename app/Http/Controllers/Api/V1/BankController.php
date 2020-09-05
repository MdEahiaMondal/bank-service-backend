<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BanksRequest;
use App\Models\Bank;
use App\Models\BankAdmin;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends ApiController
{
    public function index()
    {
        $banks = Bank::with('user')->latest()->paginate(5);
        return $this->showDataResponse('banks', $banks);
    }

    public function getAllbanksPaginate(Request  $request)
    {
        $banks = Bank::with('user')->paginate(10);
        return $this->showDataResponse('banks', $banks);
    }

    public function store(BanksRequest $request)
    {
        $request['created_by'] =  Auth::id() ?? 1; // 0
        $request['updated_by'] =  Auth::id() ?? 1; // 0

        $only = $request->only('name', 'location', 'created_by', 'updated_by', 'status');

        $bank = Bank::create($only);
        return $this->showDataResponse(
            'bank', $bank,
            201,
            'Bank Created Success'
        );
    }
    public function show(Bank $bank)
    {
        return $this->showDataResponse('bank', $bank);
    }

    public function update(BanksRequest $request, Bank $bank)
    {

        $request['updated_by'] =  Auth::id() ?? 0;

        $only = $request->only('name', 'location', 'update_by', 'status');

        $bank->update($only);

        return $this->showDataResponse(
            'bank', $bank,
            200,
            'Bank Updated Success'
        );
    }

    public function destroy(Bank $bank)
    {
        if ($bank->bankCards->count() > 0){
            return  $this->errorResponse(' Not Allow to delete! Others Information depends on  it ', 401);
        }
        $bank->delete();
        return $this->successResponse('Bank Deleted Success');
    }

    public function changeStatus($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->status = !$bank->status;
        $bank->save();
        return $this->successResponse('Bank Status Changed Success');
    }

    public function liveSearchBanks(Request  $request)
    {
        $banks = Bank::with('user')
            ->where('name', 'like', '%'.$request->text.'%')
            ->orWhere('location', 'like', '%'.$request->text.'%')
            ->paginate(10);
        return $this->showDataResponse('banks', $banks);
    }

}
