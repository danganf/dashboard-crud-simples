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

    Route::any('/{method}/{destiny}/{path?}', 'RequestController@action' )->name('factory');

});
