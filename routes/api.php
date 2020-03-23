<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group( [ 'namespace' => 'Api' ], function () {

    Route::match(['POST', 'OPTIONS'], '/auth', 'MainController@auth' )->name('auth');

    Route::get('reset-cache', function () {
        \Artisan::call('cache:clear');
        return msgSuccessJson('OK');
    });

    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/avaible' , 'CustomerController@getAvaible' )->name('avaible');
        Route::get('/{id?}'   , 'CustomerController@index' )->name('filter');
        Route::post('/'       , 'CustomerController@create' )->middleware('check.json')->name('save');
        Route::put('/{id}'    , 'CustomerController@create' )->middleware('check.json')->name('save');
        Route::delete('/{id}' , 'CustomerController@delete' )->name('delete');
    });


    Route::any('/{method}/{destiny}/{path?}', 'RequestController@action' )->name('factory');

});
