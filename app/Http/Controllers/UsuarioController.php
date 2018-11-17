<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Validator;
// use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{

  use RegistersUsers;

  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('checkAccess');
  }
  

  public function listar(){
    $usuarios = Usuario::where('tipo_conta','A')->orwhere('tipo_conta','C')->orwhere('tipo_conta','S')->get();

    return view('usuario.listar', ['usuarios'=> $usuarios]);
  }

  public function novo_usuario(){
    return view('usuario.modal.usuario');
  }

  public function cadastrar_usuario(Request $request){
    $this->validate($request,[
      'nome' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:usuario',
      'senha' => 'required|string|min:6',
      'tipo_conta' => 'required|regex:/^[A,C,S]$/u',
    ]);

    // adiciona um novo usuario
    $usuario = new Usuario();
    $usuario->nome = $request->input('nome');
    $usuario->email = $request->input('email');
    $usuario->senha = Hash::make($request->input('senha'));    
    $usuario->situacao = 'A';
    $usuario->tipo_conta = $request->input('tipo_conta');
    $usuario->id_criador = Auth::user()->id;
    $usuario->data_criacao = time();
    $usuario->id_modificador = Auth::user()->id;
    $usuario->data_modificacao = time();
    if($usuario->save()){
      return redirect()->route('listar_usuarios');
    }
    
  }

  public function editar_usuario($id){
    //TODO verifica se venho o id

    $usuario = Usuario::find($id);
    return view('usuario.modal.usuario',['usuario' => $usuario]);    
  }

  public function salvar_usuario(Request $request){
    //pega user que foi alterado

    $valida_id = Validator::make($request->all(), [
      'id_usuario' => 'required',
    ]);

    if ($valida_id->fails()){
      return back()->withErrors($valida_id)->withInput();
    }
    
    $usuario = Usuario::find($request->input('id_usuario'));
    
    //quando usuario envia o mesmo email, alterando outras informações
    if($usuario->email == $request->input('email') ){
      
      $this->validate($request,[
        'nome' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'senha' => 'required|string|min:6',
        'tipo_conta' => 'required|regex:/^[A,C,S]$/u',
      ]);
  
    }else{
      //quando usuario envia o email diferente, alterando outras informações
      $this->validate($request,[
        'nome' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:usuario',
        'senha' => 'required|string|min:6',
        'tipo_conta' => 'required|regex:/^[A,C,S]$/u',
      ]);
    }

    $usuario->nome = $request->input('nome');
    $usuario->email = $request->input('email');
    $usuario->senha = Hash::make($request->input('senha'));    
    $usuario->situacao = 'A';
    $usuario->tipo_conta = $request->input('tipo_conta');
    // $usuario->id_criador = Auth::user()->id;
    // $usuario->data_criacao = time();
    $usuario->id_modificador = Auth::user()->id;
    $usuario->data_modificacao = time();
    if($usuario->save()){
      return redirect()->route('listar_usuarios');
    }
  
  }

  public function mudar_situacao($id){
    $usuario = Usuario::find($id);
    return view('usuario.modal.situacao',['usuario' => $usuario]); 
  }

  public function salvar_situacao(Request $request){
    $this->validate($request,[
      'id_usuario' => 'required',
    ]);
    
    $usuario = Usuario::find($request->input('id_usuario'));
    $usuario->situacao  = ($usuario->situacao == 'A') ? 'I' : 'A';
    $usuario->id_modificador = Auth::user()->id;
    $usuario->data_modificacao = time();
    if($usuario->save()){
      return redirect()->route('listar_usuarios');
    }


  }

}

