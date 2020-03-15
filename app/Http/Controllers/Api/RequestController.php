<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\MyClass\FactoryApis;
use Illuminate\Http\Request;
use IntercaseDefault\MyClass\Validator;

class RequestController extends Controller
{
    public function action($method, $destiny, $path=null, Request $request, Validator $validator, FactoryApis $factoryApis){

        if( $validator->valid([ 'method' => strtoupper($method) ], ['method']) ){

            $factoryApis->setRequest($request);
            $result =  $factoryApis->{$method}($destiny, $path);
            if( empty( $factoryApis->getError() ) ){
                return msgJson( $result );
            }

        }

        $msgError = $factoryApis->getError();
        return msgErroJson( !empty( $msgError ) ? $msgError : \Lang::get('default.parameters_incorrets'), $factoryApis->getRequestCode() );

    }
}