<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAdminsRequest;
use App\Models\Bank;
use App\Models\BankAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BankAdminController extends ApiController
{

    public function index()
    {
        $bank_admins = BankAdmin::paginate(10);
        return $this->showDataResponse('bank_admins',$bank_admins);

    }

    public function store(BankAdminsRequest $request)
    {
        $bank = Bank::find(5);

        $request['user_id'] = $request->user_id;
        $request['bank_id'] = $bank->id;
        $request['name'] = $request->name;
        $request['designation'] = $request->designation;
        $request['per_user_benefit'] = $request->per_user_benefit;
        $request['created_by'] = Auth::id() ?? 0;
        $request['updated_by'] = Auth::id() ?? 0;
        $request['status'] = $request->status ?? 0;

        $only =  $request->only('user_id', 'bank_id', 'name', 'designation', 'per_user_benefit', 'created_by', 'updated_by', 'status');

        $bank_admin = BankAdmin::create($only);
        if ($bank_admin->save()){
            return $this->showDataResponse('bank_admin', $bank_admin, 201);
        }
    }

    public function show(BankAdmin $bankAdmin)
    {
        return $this->showDataResponse('bankAdmin', $bankAdmin, 200);
    }

    public function update(BankAdminsRequest $request, BankAdmin $bankAdmin)
    {
        $bank = Bank::find(5);

        $request['user_id'] = $request->user_id;
        $request['bank_id'] = $bank->id;
        $request['name'] = $request->name;
        $request['designation'] = $request->designation;
        $request['per_user_benefit'] = $request->per_user_benefit;
        $request['updated_by'] = Auth::id() ?? 0;
        $request['status'] = $request->status ?? 0;

        $only =  $request->only('user_id', 'bank_id', 'name', 'designation', 'per_user_benefit', 'created_by', 'updated_by', 'status');


        $bankAdmin->update($only);

        return $this->showDataResponse('bankAdmin', $bankAdmin, 201);

    }

    public function destroy(BankAdmin $bankAdmin)
    {
        $bankAdmin->delete();
        return $this->successResponse('Bank admin deleted success');
    }

}
