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
        Route::get('/{id?}'      , 'CustomerController@index' )->name('filter');
        Route::post('/'          , 'CustomerController@create' )->middleware('check.json')->name('save');
        Route::put('/{id}'       , 'CustomerController@create' )->middleware('check.json')->name('save');
        Route::delete('/in-batch', 'CustomerController@deleteInBatch' )->middleware('check.json')->name('delete_in_batch');
        Route::delete('/{id}'    , 'CustomerController@delete' )->name('delete');
    });

    Route::prefix('catalog')->name('catalog.')->group(function () {
        Route::get('/{sku?}'              , 'CatalogController@index' )->name('filter');
        Route::post('/'                   , 'CatalogController@create' )->middleware('check.json')->name('save');
        Route::put('/{sku}'               , 'CatalogController@create' )->middleware('check.json')->name('save');
        Route::put('/{sku}/stock-in/{qtd}', 'CatalogController@stockIn')->name('stock_in');
        Route::delete('/in-batch'         , 'CatalogController@deleteInBatch' )->middleware('check.json')->name('delete_in_batch');
        Route::delete('/{sku}'            , 'CatalogController@delete' )->name('delete');
    });

    Route::any('/{method}/{destiny}/{path?}', 'RequestController@action' )->name('factory');

});
