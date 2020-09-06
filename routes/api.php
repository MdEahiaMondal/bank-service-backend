<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


// without authorization user can access
Route::post('auth/forgot-password', 'AuthController@forgotPassword');



Route::group(['namespace' => 'Api\V1', 'middleware' => 'api'], function (){

    Route::apiResource('banks', 'BankController');
    Route::get('banks/status/{id}', 'BankController@changeStatus');
    Route::get('banks-search', 'BankController@liveSearchBanks');
    Route::get('banks-paginate', 'BankController@getAllbanksPaginate');

    Route::apiResource('sliders', 'SliderController');
    Route::get('slider-status/{slug}', 'SliderController@changeStatus');
    Route::get('sliders-search', 'SliderController@liveSearchSlider');

    Route::apiResource('bank-admins', 'BankAdminController');
    Route::get('bank-admin/banks', 'BankAdminController@getAllBanks');
    Route::get('bank-admins-search', 'BankAdminController@liveSearchBankAdmin');

    Route::apiResource('bank-card-types', 'BankCardTypeController');
    Route::apiResource('card-or-loans', 'CardOrLoanController');
});
