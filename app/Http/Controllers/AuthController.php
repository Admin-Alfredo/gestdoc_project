<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $req){
        // return response()->json(['hello'=> 'Goot']);
        $token = null;
        $dataUser = $req->validate([
            'email' =>['required' , 'email'],
            'senha' => ['required']
        ]);
        // dd($dataUser);

        if($token = Auth::attempt($dataUser)){
            $req->session()->regenerate();
            return redirect()->intended('dashboard');
        }else{
            return redirect()->back()->with('erro', 'O email ou senha incorreta!');
        }
     }
}
