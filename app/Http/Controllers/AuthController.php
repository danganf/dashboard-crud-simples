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
}
