<?php


Route::group( [ 'as' => 'auth.', 'prefix' => 'auth' ], function () {

    Route::get('/'      , 'AuthController@index' )->name('index');
    Route::get('/logoff', 'AuthController@logoff' )->name('logoff');

});

Route::group( [ 'middleware' => [ 'verify.session', 'dependency.files' ] ], function () {

    Route::get('/', 'MainController@index' )->name('main');

    Route::group( [ 'as' => 'purchase_orders.', 'prefix' => 'purchase-orders' ], function () {
        Route::get('/'           , 'PurchaseOrderController@index' )->name('index');
        Route::get('/monitor'    , 'PurchaseOrderController@monitor' )->name('monitor');
        Route::get('/new'        , 'PurchaseOrderController@new' )->name('new');
        Route::get('/edit/{code}', 'PurchaseOrderController@edit' )->name('edit');
    });

});
