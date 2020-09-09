<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    use ApiResponser;

    use SendsPasswordResetEmails;


    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reset_url' => 'required',
        ]);
        Session::put('reset_url', $request->reset_url);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email');
    }



    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->successResponse('You are  received a password reset request. Please check your email');
    }


    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->errorResponse('Something is wrong with you email', 422);
    }

}
