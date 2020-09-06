<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankCardTypesRequest;
use App\Models\BankCardType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankCardTypeController extends ApiController
{

    public function index()
    {
        $bank_card_types = BankCardType::with('bank')->latest()->paginate(10);
        return $this->showDataResponse('bank_card_types', $bank_card_types);
    }

    public function store(BankCardTypesRequest $request)
    {
        $request['created_by'] = Auth::id() ?? 0;
        $request['updated_by'] = Auth::id() ?? 0;
        $request['slug'] = $request->name .'-' . time();
        $request['status'] = $request->status ? 1 : 0 ;

        $only = $request->only('bank_id', 'name', 'created_by', 'updated_by', 'slug', 'status');
        $bank_card_type = BankCardType::create($only);

        return $this->showDataResponse('bank_card_type', $bank_card_type, 201);
    }

    public function show(BankCardType $bankCardType)
    {
        return $this->showDataResponse('bankCardType', $bankCardType, 200);
    }

    public function update(BankCardTypesRequest $request, BankCardType $bankCardType)
    {
        $request['name'] = $request->name;
        $request['updated_by'] = Auth::id() ?? 0;
        $request['status'] = $request->status ?? 0;

        $only = $request->only('name', 'created_by', 'updated_by', 'status');
        $bankCardType->update($only);

        return $this->showDataResponse('bankTypeCard', $bankCardType, 201);
    }

    public function destroy(BankCardType $bankCardType)
    {
        $bankCardType->delete();
        return $this->successResponse('Bank card type delete success');
    }
}
