<?php

namespace App\Http\Controllers;
use App\Fornecedor;

use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


   

    public function listar(){
        $fornecedores = Fornecedor::all();
        return view('fornecedor.listar', ['fornecedores'=> $fornecedores]);
    }

    public function novo(){
        //mostra modal para cadastrar novo fornecedor
        return view('fornecedor.modal.fornecedor');
    }


    public function cadastrar_fornecedor(Request $request){        
        $this->validate($request,[
           'nome' => 'required',
           'cnpj' => 'required',
           'telefone' => 'required',
           'email' => 'required',
        
        ]);

        
        $fornecedor = new Fornecedor();
        $fornecedor->nome = $request->input('nome');
        $fornecedor->cnpj = $request->input('cnpj');
        // $fornecedor->status_contato_forn = $request->input('#');
        $fornecedor->telefone = $request->input('telefone');
        $fornecedor->email = $request->input('email');
        // $fornecedor->categoria = $request->input('categoria');
        $fornecedor->id_criador = Auth::user()->id;
        $fornecedor->data_criacao = time();

        
        return redirect()->route('listar_fornecedores');
        
    }
}
