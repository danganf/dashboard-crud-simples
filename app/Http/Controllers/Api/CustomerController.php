<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController
{
    private $repository;
    public function __construct( CustomerRepository $customerRepository )
    {
        $this->repository = $customerRepository;
    }

    public function getAvaible( Request $request ){
        return msgJson( $this->repository->getAvaible( $request->all() ) );
    }

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id='', Request $request){

        $gateData = $this->pdvApi->employee();
        if( empty( $id ) )
            $result = $gateData->filter($request->all());
        else
            $result = $gateData->getById($id);

        $paginator = [];
        $metas     = $gateData->getPaginator(true);
        if( !empty( $metas ) ) {
            $paginator = $metas;
        }

        return msgJson( $result, 200, $paginator );
    }

    /**
     * @param null $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($id=null, Request $request){

        $json = $request->get('json');

        if( $request->method() == 'POST' ){$id=null;}

        if( $this->repository->createOrUpdate($json,$id) === TRUE ) {
            return msgSuccessJson('OK', [], $request->method() === 'POST' ? 201 : 200 );
        } else {
            $msg = $this->repository->getMsgError();
        }

        return msgErroJson($msg);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){

        $id  = (int) $id;
        $msg = \Lang::get('default.register_not_exist');

        if( $this->repository->delete( $id ) ){
            return msgSuccessJson('OK');
        }

        return msgErroJson($msg);
    }

}