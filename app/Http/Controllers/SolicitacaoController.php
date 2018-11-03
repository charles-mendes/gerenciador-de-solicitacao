<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
use App\Servico;
use App\Detalhe_Solicitacao_Produto;
use App\Detalhe_Solicitacao_Servico;
use Validator;
//use Request;
use Auth;
//use Input;
use Illuminate\Http\Request;


//TROCAR VARIAVEL DA TABELA SOLICITACAO PARA ENUM('A','P','I');

class SolicitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function nova(){
        
        //verificando se session não existe
        if(!session()->has('novaSolicitacao')){
            session(['novaSolicitacao' => new \stdClass() ]);
        }
        
        return view('solicitacao.nova');      
    }
    
    public function listar(){
        
        $solicitacoes = Solicitacao::all();
        //mandar para tela listar com os produtos e com os servicos
        return view('solicitacao.listar', ['solicitacoes'=> $solicitacoes]);

    }

    
    public function detalhe($id){
        //pegando solicitacao
        $solicitacao = Solicitacao::find($id);
        return view('solicitacao.detalhe',['solicitacao'=> $solicitacao]);        
    }


    public function cadastrar_solicitacao(Request $request){
        $this->validate($request,[
            'descricao'=>'required',
        ]);

        
        
        //cria uma solicitacao
        $solicitacao = new Solicitacao();
        $solicitacao->status = 'P';
        $solicitacao->descricao = $request->input('descricao');
        $solicitacao->id_criador = Auth::user()->id;
        $solicitacao->data_criacao = time();
        $solicitacao->id_modificador = Auth::user()->id;
        $solicitacao->data_modificacao = time();
        $solicitacao->save();
        
        //pegando solicitacao da session
        $solicitacaoSession = session('novaSolicitacao');
        // dd($solicitacaoSession);
        // dd($solicitacaoSession);
        foreach ($solicitacaoSession as $key => $categoria) {
            //categoria = servico ou produto
            // dd($key,$categoria,$solicitacaoSession);
            if($key == 'produtos'){
                foreach($categoria as $item){
                    $produto = new Produto();
                    $produto->id_contrato = 0;
                    $produto->nome = $item->nome;
                    $produto->quantidade = $item->quantidade;
                    $produto->valor = $item->valor;
                    $produto->valor_imposto = $item->valor_imposto;
                    $produto->descricao = $item->descricao;
                    $produto->link_oferta = $item->link_oferta;
                    $produto->id_criador = $item->id_criador;
                    $produto->data_criacao = $item->data_criacao;
                    $produto->id_modificador = $item->id_modificador;
                    $produto->data_modificacao = $item->data_modificacao;
                    $produto->save();

                    $solicitacao_produto  = new Detalhe_Solicitacao_Produto();
                    $solicitacao_produto->id_solicitacao = $solicitacao->id;
                    $solicitacao_produto->id_produto = $produto->id;
                    $solicitacao_produto->save();
                }
            }
            
           
            if($key == 'servicos'){
                // dd($categoria);
                foreach($categoria as $item){
                    $servico = new Servico();
                    $servico->id_contrato = 0;
                    $servico->nome = $item->nome;
                    // $servico->quantidade = $item->quantidade;
                    $servico->valor = $item->valor;
                    $servico->valor_imposto = $item->valor_imposto;
                    $servico->descricao = $item->descricao;
                    // $servico->link_oferta = $item->link_oferta;
                    // $servico->id_criador = $item->id_criador;
                    // $servico->data_criacao = $item->data_criacao;
                    // $servico->id_modificador = $item->id_modificador;
                    // $servico->data_modificacao = $item->data_modificacao;
                    $servico->save();

                    $solicitacao_servico  = new Detalhe_Solicitacao_Servico();
                    $solicitacao_servico->id_solicitacao = $solicitacao->id;
                    $solicitacao_servico->id_servico = $servico->id;
                    $solicitacao_servico->save();
                }

            }
        }

        return redirect()->route('listar_solicitacao');

    }


}
