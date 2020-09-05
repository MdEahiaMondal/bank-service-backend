<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAdminsRequest;
use App\Models\Bank;
use App\Models\BankAdmin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class BankAdminController extends ApiController
{

    public function index()
    {
        $bank_admins = BankAdmin::paginate(10);
        return $this->showDataResponse('bank_admins',$bank_admins);
    }
    public function getAllBanks()
    {
        $banks = Bank::active()->get();
        return $this->showDataResponse('banks',$banks);
    }

    public function store(BankAdminsRequest $request)
    {
        if ($request->hasFile('photo')){
            $this->validate($request, [
                'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024'
            ]);
        }

        $slug = Str::slug($request->name);
        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $image_name = CommonController::fileUploaded(
                $slug, false, $image, 'bank_admins', ['width' => '128', 'height' => '128']
            );
            $request['image'] = $image_name;
        }

        $request['password'] = Hash::make($request->password);
        $request['user_type'] = 'bank-admin';
        $request['status'] = 1;
        $request['created_by'] = Auth::id() ??  1;
        $request['updated_by'] = Auth::id() ??  1;

        $user_only = $request->only(
            'name',
            'email',
            'phone',
            'password',
            'present_address',
            'permanent_address',
            'image',
            'user_type',
            'status',
            'created_by',
            'updated_by'
        );

        $user_created = User::create($user_only);

        info($user_created);

        $request['user_id'] = $user_created->id;

        $bank_admin_only =  $request->only(
            'user_id',
            'bank_id',
            'designation',
            'per_user_benefit',
            'created_by',
            'updated_by',
            'status'
        );

        $bank_admin = BankAdmin::create($bank_admin_only);
        return $this->showDataResponse('bank_admin', $bank_admin, 201, 'Bank Admin Created Success');
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
