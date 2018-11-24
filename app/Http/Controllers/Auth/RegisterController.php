<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Usuario;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/solicitacao';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        $usuario  = new Usuario();
        $usuario->nome = $data['name'];
        $usuario->email = $data['email'];
        $usuario->senha = Hash::make($data['password']);
        $usuario->situacao = 'A';
        $usuario->id_criador = 0;
        $usuario->id_modificador = 0;
        $usuario->tipo_conta = 'S';
        
        // return Usuario::create([
        //     'nome' => $data['name'],
        //     'email' => $data['email'],
        //     'senha' => Hash::make($data['password']),
        //     'situacao' => 'A',
        //     'id_criador' => 0,
        //     'id_modificador' => 0,
        // ]);
        $usuario->save();
        return $usuario;
    }
}
