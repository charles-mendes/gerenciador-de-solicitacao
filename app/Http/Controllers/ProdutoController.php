<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function novo_produto(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.produto');
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_produto(Request $request){

        $this->validate($request,[
           'name' => 'required',
           'quantidade' => 'required',
            'valor'=> 'required',
           // 'imposto'=>'',
           // 'descricao'=>'required',
           // 'link-oferta'=>'',
        ]);

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');
        
        $produto = new \stdClass();
        $produto->nome = $request->input('name');
        $produto->quantidade = $request->input('quantidade');
        $produto->valor = $request->input('valor');
        $produto->valor_imposto = $request->input('imposto');
        $produto->descricao = $request->input('descricao');
        $produto->link_oferta = $request->input('link_oferta');
        $produto->id_criador = Auth::user()->id;
        $produto->data_criacao = time();
        $produto->id_modificador = Auth::user()->id;
        $produto->data_modificacao = time();

        
        //adicionando o novo produto na sessao
        $solicitacao->produtos[]= $produto;

        session()->put('novaSolicitacao', $solicitacao);
        
        return redirect()->route('nova_solicitacao');
        
    }

    public function edita_produto($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.produto',['id' => $id]);    
        }
        
        return redirect()->route('nova_solicitacao');
    }

    public function salvar_produto(Request $request){
        $this->validate($request,[
            'id_produto' => 'required',
            'name' => 'required',
            'quantidade' => 'required',
            'valor'=> 'required',
            // 'imposto'=>'',
            // 'descricao'=>'required',
            // 'link-oferta'=>'',
         ]);

        
        //pegando o id do produto
        $id = $request->input('id_produto');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
        
        //alterar produto ja existente na session
        $solicitacao->produtos[$id]->nome = $request->input('name');
        $solicitacao->produtos[$id]->quantidade = $request->input('quantidade');
        $solicitacao->produtos[$id]->valor = $request->input('valor');
        $solicitacao->produtos[$id]->valor_imposto =  $request->input('imposto');
        $solicitacao->produtos[$id]->descricao = $request->input('descricao');
        $solicitacao->produtos[$id]->link_oferta = $request->input('link_oferta');
        $solicitacao->produtos[$id]->id_criador = Auth::user()->id;
        $solicitacao->produtos[$id]->id_modificador = Auth::user()->id;
        
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        return redirect()->route('nova_solicitacao');
    }

}
