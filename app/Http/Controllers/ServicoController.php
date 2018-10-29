<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function novo_servico(){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.servico');
        }
        return redirect()->route('nova_solicitacao');
    }

    public function cadastrar_servico(Request $request){
        // dd($request->input());
        $this->validate($request,[
           'name' => 'required',
        //    'quantidade' => 'required',
            'valor'=> 'required',
           // 'imposto'=>'',
           'descricao'=>'required',
           // 'link-oferta'=>'',
        ]);

        // adiciona um novo produto
        $solicitacao = session('novaSolicitacao');
        
        $servico = new \stdClass();
        $servico->nome = $request->input('name');
        $servico->quantidade = $request->input('quantidade');
        $servico->valor = $request->input('valor');
        $servico->valor_imposto = $request->input('imposto');
        $servico->descricao = $request->input('descricao');
        $servico->link_oferta = $request->input('link_oferta');
        $servico->id_criador = Auth::user()->id;
        $servico->id_modificador = Auth::user()->id;

        
        //adicionando o novo produto na sessao
        $solicitacao->servicos[]= $servico;

        session()->put('novaSolicitacao', $solicitacao);
        
        return redirect()->route('nova_solicitacao');
        
    }


    public function edita_servico($id){
        //verifica se a session existe, se não existir ele redireciona a nova solicitacao
        if(session()->has('novaSolicitacao')){
            return view('solicitacao.modal.servico',['id' => $id]);    
        }
        
        return redirect()->route('nova_solicitacao');
    }


    public function salvar_servico(Request $request){
        $this->validate($request,[
            'id_servico' => 'required',
            'name' => 'required',
            // 'quantidade' => 'required',
            'valor'=> 'required',
            // 'imposto'=>'',
            'descricao'=>'required',
            // 'link-oferta'=>'',
         ]);

        
        //pegando o id do servico
        $id = $request->input('id_servico');
         
        //pegando solicitacao da session
        $solicitacao = session('novaSolicitacao');
        
        //alterar produto ja existente na session
        $solicitacao->servicos[$id]->nome = $request->input('name');
        $solicitacao->servicos[$id]->quantidade = $request->input('quantidade');
        $solicitacao->servicos[$id]->valor = $request->input('valor');
        $solicitacao->servicos[$id]->valor_imposto =  $request->input('imposto');
        $solicitacao->servicos[$id]->descricao = $request->input('descricao');
        $solicitacao->servicos[$id]->link_oferta = $request->input('link_oferta');
        $solicitacao->servicos[$id]->id_criador = Auth::user()->id;
        $solicitacao->servicos[$id]->id_modificador = Auth::user()->id;
        
        //adicionando alterações na solicitação 
        session()->put('novaSolicitacao', $solicitacao);

        return redirect()->route('nova_solicitacao');
    }
}
