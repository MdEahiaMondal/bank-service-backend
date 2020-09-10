<?php

namespace App\Http\Controllers\Api\V1\Superadmin;

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
        $bank_admins = User::has('bankAdmin')
            ->with('bankAdmin', 'bankAdmin.bank')
            ->where('user_type', '=', 'bank-admin')
            ->latest()
            ->paginate(10);
        return $this->showDataResponse('bank_admins', $bank_admins);
    }

    public function getAllBanks()
    {
        $banks = Bank::active()->get();
        return $this->showDataResponse('banks', $banks);
    }

    public function store(BankAdminsRequest $request)
    {
        if ($request->hasFile('photo')) {
            $this->validate($request, [
                'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024'
            ]);
        }

        $slug = Str::slug($request->name);
        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $image_name = CommonController::fileUploaded(
                $slug, false, $image, 'users', ['width' => '128', 'height' => '128']
            );
            $request['image'] = $image_name;
        }

        $request['password'] = Hash::make($request->password);
        $request['user_type'] = 'bank-admin';
        $request['status'] = 1;
        $request['created_by'] = Auth::id() ?? 1;
        $request['updated_by'] = Auth::id() ?? 1;
        $request['slug'] = $request->name;

        $user_only = $request->only(
            'name',
            'slug',
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
        $bank_admin_only = $request->only(
            'bank_id',
            'user_id',
            'designation',
            'per_user_benefit',
            'created_by',
            'updated_by',
            'status'
        );
        BankAdmin::create($bank_admin_only);

        $bank_admin = User::has('bankAdmin')
            ->with('bankAdmin', 'bankAdmin.bank')
            ->where(['user_type' => 'bank-admin', 'slug' => $user_created->slug])->first();
        return $this->showDataResponse('bank_admin', $bank_admin, 201, 'Bank Admin Created Success');
    }


    public function show($slug)
    {
        $bank_admin = User::has('bankAdmin')
            ->with('bankAdmin', 'bankAdmin.bank')
            ->where('user_type', '=', 'bank-admin')
            ->where('slug', '=', $slug)->first();
        if ($bank_admin) {
            return $this->showDataResponse('bank_admin', $bank_admin);
        } else {
            return $this->errorResponse('Not Found', 404);
        }
    }


    public function update(BankAdminsRequest $request, $slug)
    {
        $bank_admin = User::has('bankAdmin')
            ->with('bankAdmin', 'bankAdmin.bank')
            ->where(['user_type' => 'bank-admin', 'slug' => $slug])->first();

        if ($bank_admin) {

            if ($request->hasFile('photo')) {
                $this->validate($request, [
                    'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024'
                ]);
            }

            $slug = Str::slug($request->name);
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $image_name = CommonController::fileUploaded(
                    $slug, false, $image, 'users', ['width' => '128', 'height' => '128']
                );
                $request['image'] = $image_name;
                if ($bank_admin->image) {
                    CommonController::deleteImage('users', $bank_admin->image);
                }
            }

            $request['updated_by'] = Auth::id() ?? 1;

            $user_only = $request->only(
                'name',
                'email',
                'phone',
                'present_address',
                'permanent_address',
                'image',
                'updated_by'
            );

            $bank_admin->update($user_only);

            // updated related table
            $bank_admin->bankAdmin->bank_id = $request->bank_id;
            $bank_admin->bankAdmin->designation = $request->designation;
            $bank_admin->bankAdmin->per_user_benefit = $request->per_user_benefit;
            $bank_admin->bankAdmin->updated_by = $request->updated_by;
            $bank_admin->bankAdmin->save();

            return $this->showDataResponse('bank_admin', $bank_admin, 200, 'Bank Admin updated success');

        } else {
            return $this->errorResponse('Not Found', 404);
        }
    }


    public function destroy($slug)
    {
        $bank_admin = User::has('bankAdmin')
            ->with('bankAdmin', 'bankAdmin.bank')
            ->where(['user_type' => 'bank-admin', 'slug' => $slug])->first();
        if ($bank_admin) {
            if ($bank_admin->image) {
                CommonController::deleteImage('users', $bank_admin->image);
            }
            $bank_admin->delete();
            return $this->successResponse('Bank admin deleted success');
        } else {
            return $this->errorResponse('Not Found', 404);
        }
    }

    public function liveSearchBankAdmin(Request $request)
    {
        $search_text = $request->text;
        $search_result = User::has('bankAdmin')->with(['bankAdmin' =>  function ($query) use($search_text){
            $query->where('per_user_benefit', $search_text)->with('bank');
        }])
        ->where('user_type', 'bank-admin')
        ->latest()
        ->paginate(10);
        return $this->showDataResponse('bank_admins', $search_result);

        /* ->orWhere('name', 'like', '%' .  $search_text . '%')
        ->orWhere('phone', 'like', '%' . $search_text . '%')
        ->orWhere('email', 'like', '%' . $search_text . '%')
        ->orWhere('name', 'like', '%' .  $search_text . '%')*/
    }


}
