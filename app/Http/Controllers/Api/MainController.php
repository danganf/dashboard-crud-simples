<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\MyClass\FactoryApis;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Validator;

class MainController extends Controller
{
    private $pdvApi;

    public function __construct()
    {

    }

    public function auth( Request $request, UserRepository $userRepository ){

        $validator = Validator::make( $request->all() , [
            'login'    => 'required|min:4',
            'password' => 'required|min:4'
        ] );

        if ( !$validator->fails() ) {
            $return = $userRepository->auth( $request->get('login'), $request->get('password') );
            if( !empty( $return ) ){

                $request->session()->put( 'userData', [
                    'id'    => $return['id'],
                    'email' => $return['email'],
                    'name'  => $return['name'],
                    'when'  => getDateNow(),
                ] );

                return msgSuccessJson('OK');
            }
            return msgErroJson( \Lang::get('auth.failed'), 401 );
        } else {
            return msgErroJson($validator->errors()->first(), 400);
        }

    }

    public function createLogError(Request $request, LogDebug $logDebug){
        $logDebug->setLogFile('JavaScript');
        $logDebug->error( '', $request->all() );
    }

    public function logoff(Request $request){
        $request->session()->flush();
        return redirect()->route('auth.index');
    }

    public function printNFC( $orderID, Curl $curl ){
        $url    = str_replace( '_ORDER_ID_', $orderID, config('app.endpoint_print_nfce') );
        $return = $curl->send( $url );
        if(  $return['HTTP_CODE'] === 200 ){ return msgSuccessJson(  'OK' ); }
        return msgErroJson('Ocorreu um problema ao imprimir a NFCe');

    }
}
