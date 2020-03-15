<?php

namespace App\Http\Controllers;

use App\MyClass\FactoryApis;
use App\MyClass\PdvApi;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('auth.index');
    }

    public function logoff(Request $request){
        $request->session()->flush();
        return redirect()->route('auth.index');
    }

    public function authByToken($token=null, PdvApi $pdvApi, Request $request, FactoryApis $factoryApis){
        $return = $factoryApis->get('employee', 'auth-by-token@' . $token );
        if( !empty( $return ) ){
            $request->session()->flush();
            $pdvApi->employee()->startSession( $return, $request, $factoryApis );
            return redirect()->route('main');
        }
        return redirect()->route('auth.index');
    }
}
