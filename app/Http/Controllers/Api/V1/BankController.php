<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CommonController;
use App\Http\Requests\BanksRequest;
use App\Models\Bank;
use App\Models\BankAdmin;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BankController extends ApiController
{
    public function index()
    {
        $banks = Bank::with('createdUser')
            ->latest()
            ->paginate(10);
        return $this->showDataResponse('banks', $banks);
    }

    public function store(BanksRequest $request)
    {
        $slug = Str::slug($request->name);
        $request['created_by'] =  Auth::id() ?? 1;
        $request['updated_by'] =  Auth::id() ?? 1;
        $request['slug'] =  $slug;
        $request['status'] =  $request->status == 'true' ? 1 : 0;


        // image upload
        if ($request->hasFile('photo')) {
            $this->validate($request, [
                'photo' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            $image = $request->file('photo');
            $image_name = CommonController::fileUploaded($slug, false, $image, 'banks', ['width' => '200', 'height' => '200',]);
            $request['image'] = $image_name;
        }


        $only = $request->only('name', 'slug', 'image', 'location', 'created_by', 'updated_by', 'status');


        $bank = Bank::create($only);

        // get relational data
        $bankWithRelationalData = Bank::with('createdUser')
            ->findOrFail($bank->id);


        return $this->showDataResponse(
            'bank', $bankWithRelationalData,
            201,
            'Bank Created Success'
        );
    }

    public function show(Bank $bank)
    {
        return $this->showDataResponse('bank', $bank);
    }


    public function edit(Bank $bank){
        $data = [];
        $data['name'] = $bank->name;
        $data['slug'] = $bank->slug;
        $data['photo'] = $bank->image_url;
        $data['location'] = $bank->location;
        $data['status'] = $bank->status;
        return $this->showDataResponse('bank', $data);
    }


    public function update(BanksRequest $request, Bank $bank)
    {
        $slug = Str::slug($request->name);
        $request['updated_by'] =  Auth::id() ?? 1;
        $request['slug'] =  $slug;
        $request['status'] =  $request->status == 'true' ? 1 : 0;

        // image upload
        if ($request->hasFile('photo')) {
            $this->validate($request, [
                'photo' => 'sometimes|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            $image = $request->file('photo');
            $image_name = CommonController::fileUploaded($slug, false, $image, 'banks', ['width' => '200', 'height' => '200',], $bank->image);
            $request['image'] = $image_name;
        }

        $only = $request->only('name', 'slug', 'image', 'location', 'updated_by', 'status');

        $bank->update($only);

        // get relational data
        $bankWithRelationalData = Bank::with('createdUser')
            ->findOrFail($bank->id);

        return $this->showDataResponse(
            'bank', $bankWithRelationalData,
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


    public function changeStatus($slug)
    {
        $bank = Bank::where('slug', $slug)->first();

        if ($bank){
            $bank->status = !$bank->status;
            $bank->save();
            return $this->successResponse('Bank Status Changed Success');
        }else{
            return $this->errorResponse('Does not exist bank with the specified identificator', 404);
        }
    }

    public function liveSearchBanks(Request  $request)
    {
        $banks = Bank::with('createdUser')
            ->where('name', 'like', '%'.$request->text.'%')
            ->orWhere('location', 'like', '%'.$request->text.'%')
            ->paginate(10);
        return $this->showDataResponse('banks', $banks);
    }

}
