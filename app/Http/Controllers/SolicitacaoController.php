<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
use Validator;
//use Request;
use Auth;
//use Input;
use Illuminate\Http\Request;
use App\Detalhe_Produto_Solicitacao;

class SolicitacaoController extends Controller
{
    
    public function index(){
        return view('solicitacao.index');
    }

    public function nova(){
        //cria uma nova solicitação
        $solicitacao = new Solicitacao;
        $solicitacao->status = "A";
        $solicitacao->descricao = "nao sei pq desse campo";
        $solicitacao->id_criador = Auth::user()->id;
        $solicitacao->data_criacao = time();
        $solicitacao->id_modificador = Auth::user()->id;
        $solicitacao->data_modificacao = time(); 
        
        if($solicitacao->save()){
            session(['solicitacao_id' => $solicitacao->id]);
            return view('solicitacao.nova');
        }
        
    }

    public function cadastrar_produto(Request $request){

        $this->validate($request,[
           // 'name' => 'required',
           // 'quantidade' => 'required',
            //'valor'=> 'required',
           // 'imposto'=>'',
           // 'descricao'=>'required',
           // 'link-oferta'=>'',
        ]);

        // adiciona um novo produto
        $produto = new Produto;
        $produto->id_contrato = 0;
        $produto->nome = $request->input('name');
        $produto->quantidade = $request->input('quantidade');
        $produto->valor = $request->input('valor');
        $produto->valor_imposto = $request->input('imposto');
        $produto->descricao = $request->input('descricao');
        $produto->link_oferta = $request->input('link-oferta');
        $produto->id_criador = Auth::user()->id;
        //$produto->data_criacao = time();
        $produto->id_modificador = Auth::user()->id;
        //$produto->data_modificacao = time(); 
        
        
        if($produto->save()){
            //adiciona produto a uma solicitacao
            $detalhe_produto_solicitacao = new Detalhe_Produto_Solicitacao;
            $detalhe_produto_solicitacao->id_solicitacao = session('solicitacao_id');
            $detalhe_produto_solicitacao->id_produto = $produto->id ;
            $detalhe_produto_solicitacao->save();

            return view('solicitacao.nova');
        }
    }



}
