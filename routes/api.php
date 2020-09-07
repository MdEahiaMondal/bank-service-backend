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


Route::group(['namespace' => 'Api\V1', 'middleware' => 'api'], function () {

/*start supper admin work*/

    // start bank
    Route::resource('banks', 'BankController')->scoped(['bank' => 'slug'])->except(['create']);
    Route::get('banks/status-change/{slug}', 'BankController@changeStatus')->name(' banks.status');
    Route::get('banks-search', 'BankController@liveSearchBanks');

    Route::get('bank/cards-search', 'BankCardController@liveSearchBankCards')->name('cards.search');
    Route::resource('banks.cards', 'BankCardController')->scoped(['bank' => 'slug', 'card' => 'slug'])->except(['create']);




    // start slider
    Route::resource('sliders', 'SliderController')->scoped(['slider' => 'slug'])->except(['create']);;
    Route::get('slider-status-change/{slug}', 'SliderController@changeStatus');
    Route::get('sliders-search', 'SliderController@liveSearchSlider');


    /*;
    Route::get('banks-paginate', 'BankController@getAllbanksPaginate');*/


    // start bank admin
    Route::apiResource('bank-admins', 'BankAdminController');
    Route::get('bank-admin/banks', 'BankAdminController@getAllBanks');
    Route::get('bank-admins-search', 'BankAdminController@liveSearchBankAdmin');

    // start bank card type
//    Route::apiResource('bank-card-types', 'BankCardTypeController');

    Route::apiResource('card-or-loans', 'CardOrLoanController');


    /*end supper admin work*/

});
