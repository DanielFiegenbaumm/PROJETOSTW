<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
    public function loginView(){
        return view('login');
    }

    public function auth(Request $request) {
        $usuario = $request->input('email');
        $senha = $request->input('password');
    
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);
    
        if (Auth::attempt(['email' => $usuario, 'password' => $senha])) {
            return response()->json([
                'success' => true,
                'redirectUrl' => route('cadastroReceitaView')
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
    
    public function cadastroLogin(){
        return view('cadastroLogin');
    }

    public function cadastrarUsuario(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $novoUsuario = new User();
        $novoUsuario->name = $name;
        $novoUsuario->email = $email;
        $novoUsuario->password = $password;

        $novoUsuario->save();

    }
    
}
