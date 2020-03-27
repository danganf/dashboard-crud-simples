<?php

namespace App\Http\Controllers\Api;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function create( Request $request, OrderRepository $orderRepository ){

        $result = $orderRepository->createOrUpdate( $request->get('json') );
        if( !empty( $result ) ){
            return msgSuccessJson('OK');
        }
        return msgErroJson( $orderRepository->getMsgError() );

    }
}
