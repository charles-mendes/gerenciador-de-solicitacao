<?php

namespace App\Http\Controllers;
use App\Solicitacao;
use App\Produto;
use App\Detalhe_Solicitacao_Produto;
use Validator;
//use Request;
use Auth;
//use Input;
use Illuminate\Http\Request;


class SolicitacaoController extends Controller
{
    
    public function index(){
        
    }



    public function listar(){
        
       
        $solicitacoes = Solicitacao::all();
        //mandar para tela listar com os produtos e com os servicos

        return view('solicitacao.listar', ['solicitacoes'=> $solicitacoes]);

    }

    public function nova(){
        
        //verifica se ultima solicitação tem algo cadastrado nela 
        //se não tiver nada cadastrado nela : usar ela, se tiver criar uma nova
        $ultimaSolicitacao = Solicitacao::all()->last();

        if($ultimaSolicitacao->produtos->first() == [] && $ultimaSolicitacao->servicos->first() == []){
            session(['solicitacao' => $ultimaSolicitacao]);
        }else{
            //cria uma nova solicitação
            $solicitacao = new Solicitacao;
            $solicitacao->status = "A";
            $solicitacao->descricao = "nao sei pq desse campo";
            $solicitacao->id_criador = Auth::user()->id;
            $solicitacao->data_criacao = time();
            $solicitacao->id_modificador = Auth::user()->id;
            $solicitacao->data_modificacao = time(); 

            if($solicitacao->save()){
                session(['solicitacao' => $solicitacao]);
            }
        }
        //retornar para funcao
        return view('solicitacao.nova',['solicitacao'=> session('solicitacao')]);      
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
            $detalhe_produto_solicitacao = new Detalhe_Solicitacao_Produto;
            $detalhe_produto_solicitacao->id_solicitacao = session('solicitacao')->id;
            $detalhe_produto_solicitacao->id_produto = $produto->id ;
            $detalhe_produto_solicitacao->save();

            //Atualiza solicitação da session fazendo consulta no banco
            $solicitacao = Solicitacao::find(session('solicitacao')->id);
            session(['solicitacao' => $solicitacao]);
                        

            return view('solicitacao.nova',['solicitacao'=> session('solicitacao')]);
        }
    }

    public function detalhe($id){
        //pegando solicitacao
        // dd('');
        $solicitacao = Solicitacao::find($id);
        return view('solicitacao.detalhe',['solicitacao'=> $solicitacao]);        
    }

}
