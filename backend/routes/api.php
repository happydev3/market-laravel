<?php

Route::prefix('v1')->group(function(){

    Route::post('/login','Api\Auth\LoginController@login');
    Route::post('/user_register','Api\Auth\LoginController@register');
    Route::post('/logout','Api\Auth\LoginController@logout');

    Route::post('/user/verify/phone','Api\UserController@verifyPhoneNumber')->middleware('auth:api');
    Route::post('/user/offline_transaction','Api\UserController@initOfflineTransaction')->middleware('auth:api');
    Route::post('/user/cash_transaction','Api\UserController@proposeCashTransaction')->middleware('auth:api');

    Route::get('/user/home','Api\UserController@userHomeData')->middleware('auth:api');
    Route::get('/user/wallet','Api\UserController@userWallet')->middleware('auth:api');
    Route::get('/user/send/verify_code','Api\UserController@sendVerificationSms')->middleware('auth:api');
    Route::get('/user/partner/redirect/{id}','Api\UserController@tdRedirect')->middleware('auth:api');

    Route::get('/stores','Api\StoreController@getStores');
    Route::get('/stores/categories','Api\StoreController@getStoreCategories');
    Route::get('/stores/category/{id}','Api\StoreController@storesByCategory');
    Route::get('/stores/status/{id}','Api\StoreController@checkStoreStatus');
    Route::get('/stores/dp_status/{id}','Api\StoreController@checkStoreDpStatus');
    
    Route::get('/stores/check/desk/{code}','Api\StoreController@checkCashDesk');

    Route::get('/stores/checkout/{code}','Api\StoreController@storeCheckoutDetails');


    Route::get('/stores/cash/checkout/{deskCode}','Api\StoreController@storeCheckoutInCash');

    Route::get('/stores/{id}','Api\StoreController@storeDetails');
    Route::get('/stores/partner/{id}','Api\StoreController@tdStoreDetails');
    Route::get('/stores_around','Api\StoreController@getStoresAround');


    Route::get('/cities','Api\Auth\LoginController@getCities');
});
