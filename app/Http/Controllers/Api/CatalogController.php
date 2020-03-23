<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CatalogController
{
    private $repository;
    public function __construct( ProductRepository $productRepository )
    {
        $this->repository = $productRepository;
    }

    /**
     * @param string $sku
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index( $sku='', Request $request){

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
     * @param null $sku
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create( $sku=null, Request $request){

        $json = $request->get('json');

        if( $request->method() == 'POST' ){$sku=null;}

        if( $this->repository->createOrUpdate( $json, $sku ) === TRUE ) {
            return msgSuccessJson('OK', [], $request->method() === 'POST' ? 201 : 200 );
        } else {
            $msg = $this->repository->getMsgError();
        }

        return msgErroJson($msg);
    }

    /**
     * @param $sku
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($sku){

        $msg = \Lang::get('default.register_not_exist');

        if( $this->repository->delete( $sku, 'sku' ) ){
            return msgSuccessJson('OK');
        }

        return msgErroJson($msg);
    }

    /**
     * @param $sku
     * @param $qtd
     * @return \Illuminate\Http\JsonResponse
     */
    public function stockIn( $sku, $qtd ){

        $msg = \Lang::get('default.register_not_exist');

        if( $this->repository->stockIn( $sku, $qtd ) ){
            return msgSuccessJson('OK');
        }

        return msgErroJson($msg);
    }

}