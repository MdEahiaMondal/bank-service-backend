<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\BankCardRequest;
use App\Models\Bank;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BankCardController extends ApiController
{

    public function index(Bank $bank)
    {
        $bank_cards = $bank->cards()
            ->latest()
            ->paginate(10);
        return $this->showDataResponse('bank_cards', $bank_cards);
    }

    public function store(BankCardRequest $request, Bank $bank)
    {

        $request['created_by'] = Auth::id() ?? 1;
        $request['updated_by'] = Auth::id() ?? 1;
        $request['slug'] = Str::slug($bank->name . '-' . $request->name);
        $request['status'] = 1;
        $request['bank_id'] = $bank->id;

        $check_exist_card = Card::where(['bank_id' => $bank->id, 'name' => $request->name])->first();
        if ($check_exist_card) {
            return $this->errorResponse('This Card Name already exist', 409);
        }
        $only = $request->only('bank_id', 'name', 'created_by', 'updated_by', 'slug', 'status');
        $bank_card_type = Card::create($only);

        $bank_card = Card::with('bank', 'createdBy')
            ->find($bank_card_type->id);

        return $this->showDataResponse('bank_card', $bank_card, 201, 'Bank Card created success');
    }


    public function show(BankCard $bankCardType)
    {
        return $this->showDataResponse('bankCardType', $bankCardType, 200);
    }


    public function edit(Bank $bank, Card $card)
    {
        $this->checkCard($bank, $card);
        $data = [];
        $data['name'] = $card->name;
        $data['slug'] = $card->slug;
        return $this->showDataResponse('bank_card', $data, 200);
    }

    public function update(BankCardRequest $request, Bank $bank, Card $card)
    {

        $this->checkCard($bank, $card);

        $request['updated_by'] = Auth::id() ?? 1;
        $request['slug'] = Str::slug($bank->name . '-' . $request->name);
        $request['bank_id'] = $bank->id;


        $check_exist_card = Card::where('bank_id', '!=', $bank->id)
            ->where('name', $request->name)
            ->first();
        if ($check_exist_card) {
            return $this->errorResponse('This Card Name already exist', 409);
        }

        $only = $request->only('bank_id', 'name', 'updated_by', 'slug');
        $card->update($only);

        $bank_card = Card::with('bank', 'createdBy')
            ->find($card->id);

        return $this->showDataResponse('bank_card', $bank_card, 200, 'Bank Card updated success');
    }

    public function destroy(Bank $bank, Card $card)
    {
        $this->checkCard($bank, $card);
        $card->delete();
        return $this->successResponse('Bank card type delete success');
    }

    private function checkCard(Bank $bank, Card $card)
    {
        if ($bank->id !== $card->bank_id) {
            throw new HttpException(403, 'The specified card is not the actual card of this bank');
        }
    }


    public function liveSearchBankCards(Request  $request, $bank_slug){

       $bank = Bank::where('slug', $bank_slug)->first();
       if ($bank){
           $bank_cards = Card::with('bank', 'createdBy')
               ->where('bank_id', '=', $bank->id)
               ->where('name', 'like', '%' .$request->text. '%')
               ->latest()
               ->paginate(10);

           if ($bank_cards->count() > 0){
               return $this->showDataResponse('bank_cards', $bank_cards);
           }else{
               return $this->errorResponse('Does not exist bank with the specified identificator', 404);
           }
       }else{
           return $this->errorResponse('Does not exist bank with the specified identificator', 404);
       }

    }

}
