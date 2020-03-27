<?php

namespace App\Http\Controllers\Api;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $repository;
    public function __construct( OrderRepository $orderRepository )
    {
        $this->repository = $orderRepository;
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id='', Request $request){

        if( empty( $id ) ) {
            $result = $this->repository->filter($request->all());
            $result = format_paginate($result);
            $result['status_label'] = $this->repository::STATUS_LABEL;
        }
        else {
            $result = $this->repository->setwith('items')->find($id);
            if (!$result->fails()) {
                $result                 = $result->toArray();
                $result['status_label'] = $this->repository::STATUS_LABEL;
            }
        }

        return msgJson( $result );
    }

    public function create( Request $request ){

        $result = $this->repository->createOrUpdate( $request->get('json') );
        if( !empty( $result ) ){
            return msgJson( $result );
        }
        return msgErroJson( $this->repository->getMsgError() );

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){

        if( $this->repository->delete( $id, 'id' ) ){
            return msgSuccessJson('OK');
        }

        return msgErroJson($this->repository->getMsgError());
    }
}
