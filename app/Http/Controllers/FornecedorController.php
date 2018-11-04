<?php

namespace App\Http\Controllers;
use App\Fornecedor;
use App\Endereco;
use Auth;

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

   

    private function makeVerify($array){
        if($array['check_identificacao'] == 'on'){
            $check_identificacao = [
                'identificacao' => 'required',
            ];            
        }
        if($array['check_endereco'] == 'on'){
            $check_endereco = [
                'endereco' => 'required',
                'bairro' => 'required',
                'cidade' => 'required',
                'estado' => 'required',
                'numero' => 'required',
                'cep' => 'required',
                'pais' => 'required',
            ];
        }
        if($array['check_anexo'] == 'on'){
            $check_anexo = [
                'anexo' => 'required',
            ];  
        }

        $checkPadrao = [
            'nome' => 'required',
            'telefone' => 'required',
            'email' => 'required',
        ];
        
        //mergeando todos os vetores de validação
        $checkFinal = array_merge(
            isset($check_identificacao) ? $check_identificacao : [],
            isset($check_endereco) ? $check_endereco : [] ,
            isset($check_anexo) ? $check_anexo : [] ,
            $checkPadrao
        );
        // dd($checkFinal);

        return $checkFinal;

    }


    public function cadastrar_fornecedor(Request $request){    
        $arrayCheck = [
            'check_identificacao' => $request->input('check_identificacao'),
            'check_endereco' => $request->input('check_endereco'),
            'check_anexo' => $request->input('check_anexo')
        ];
        //realizando validação
        $this->validate($request,$this->makeVerify($arrayCheck));

        $fornecedor = new Fornecedor();
        $fornecedor->nome = $request->input('nome');
        //grava informações sobre o cpf/cnpj
        if($request->input('check_identificacao') == 'on'){
            $fornecedor->cnpj = $request->input('identificacao');    
        }
        // $fornecedor->status_contato_forn = $request->input('#');
        $fornecedor->telefone = $request->input('telefone');
        $fornecedor->email = $request->input('email');
        $fornecedor->status_contato_forn = 'A';
        $fornecedor->categoria = 'A';
        // $fornecedor->categoria = $request->input('categoria');
        $fornecedor->id_criador = Auth::user()->id;
        $fornecedor->data_criacao = time();
        $fornecedor->save();

        //grava endereco do fornecedor
        if($request->input('check_endereco') == 'on'){
            $endereco = new Endereco();
            $endereco->id_fornecedor = $fornecedor->id;           
            $endereco->endereco =  $request->input('endereco');
            $endereco->bairro =  $request->input('bairro');
            $endereco->cidade =  $request->input('cidade');
            $endereco->estado =  $request->input('estado');
            $endereco->numero =  $request->input('numero');
            $endereco->cep =  $request->input('cep');
            $endereco->pais =  $request->input('pais');
            $endereco->save();
        }
        
       //grava anexo do fornecedor
        if( $request->input('check_anexo')== 'on'){
                      
        }

        
       

        
        return redirect()->route('listar_fornecedores');
        
    }
}
